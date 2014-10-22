<?php

/**
 *
 *
 * @author     Victor Vlas <victor.vlas@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    PollModel,
    Input,
    PollAnswerModel,
    PollQuestionModel,
    PollAnswerLangModel,
    PollVotesModel,
    Language,
    Redirect,
    User,
    Route,
    Event,
    jQgrid;

class Poll extends \Core\APL\ExtensionController {

    protected $module_name = 'poll';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PollModel', 'PollAnswerLangModel', 'PollVotesModel'));

        Route::get('poll/list', array('before' => 'auth', array($this, 'poll_list')));
        Route::post('poll/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::get('poll/form', array('before' => 'auth', array($this, 'form')));
        Route::get('poll/form/{id}', array('before' => 'auth', array($this, 'form')));
        Route::post('poll/save', array('before' => 'auth', array($this, 'save')));
        Route::post('poll/save_lang', array('before' => 'auth', array($this, 'save_lang')));
        Route::post('poll/edititem', array('before' => 'auth', array($this, 'edititem')));
        Route::post('poll/edititem/{poll_lang_id}', array('before' => 'auth', array($this, 'edititem')));
        Route::post('poll/add', array('before' => 'auth', array($this, 'poll_add')));

        Route::get('poll/del', array('before' => 'auth', array($this, 'poll_del')));
        Route::get('poll/del/{id}', array('before' => 'auth', array($this, 'poll_del')));

        Route::post('poll/list/answer', array('before' => 'auth', array($this, 'getlist_answer')));
        Route::post('poll/list/answer/{poll_lang_id}', array('before' => 'auth', array($this, 'getlist_answer')));

        Route::get('poll/anwser/create/{id}', array('before' => 'auth', array($this, 'create_answer')));
        Route::get('poll/answer/edit/{id}', array('before' => 'auth', array($this, 'edit_answer')));
        Route::post('poll/answer/save', array('before' => 'auth', array($this, 'save_answer')));
        Route::get('poll/answer/delete/{id}', array('before' => 'auth', array($this, 'delete_answer')));


        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('language_created', array($this, 'language_created'));
        Event::listen('language_deleted', array($this, 'language_deleted'));

        Template::registerViewMethod('page', 'pollList', 'Lista de sondaje', null, true);

        $this->layout = Template::mainLayout();
    }

    /**
     * jqgrid view with polls list
     * @return layout
     */
    public function poll_list() {
        User::onlyHas('poll-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    /**
     * get list of polls for jqgrid
     * @return json
     */
    public function getlist() {
        User::onlyHas('poll-view');

        $jqgrid = new jQgrid('apl_poll');
        return $jqgrid->populate(function($start, $limit) {
                    return PollModel::select('apl_poll.id', 'apl_poll_question.title', 'date_created', 'enabled')
                                    ->skip($start)
                                    ->take($limit)
                                    ->leftjoin('apl_poll_question', 'apl_poll.id', '=', 'apl_poll_question.poll_id')
                                    ->where('lang_id', Language::getId())
                                    ->get();
                });
    }

    /**
     * Get list of answers jqgrid
     * @param int $poll_id
     * @param int $lang_id
     * @return json
     */
    public function getlist_answer($poll_lang_id) {
        User::onlyHas('poll-view');

        $jqgrid = new jQgrid('apl_poll_answer');
        return $jqgrid->populate(function($start, $limit) use($poll_lang_id) {
                    $answers = PollAnswerModel::select(PollAnswerModel::getField('id'), PollAnswerModel::getField('poll_id'), PollAnswerLangModel::getField('title'))
                            ->join(\PollAnswerLangModel::getTableName(), PollAnswerModel::getField('id'), '=', \PollAnswerLangModel::getField('answer_id'))
                            ->where(array(\PollAnswerLangModel::getField('lang_id') => \Core\APL\Language::getId()))
                            ->skip($start)
                            ->take($limit)
                            ->where(array('poll_id' => $poll_lang_id))
                            ->get();
                    $list = [];
                    foreach ($answers as $answer) {
                        $list[] = array(
                            'id' => $answer->id,
                            'title' => $answer->title,
                            'count' => PollVotesModel::where(array(
                                'poll_id' => $answer->poll_id,
                                'answer_id' => $answer->id
                            ))->count()
                        );
                    }
                    return $list;
                });
    }

    public function create_answer($id) {

        $answer = new \PollAnswerModel();
        $answer->poll_id = $id;
        $answer->save();

        foreach (\Core\APL\Language::getList() as $lang) {
            $answerLang = new \PollAnswerLangModel();
            $answerLang->answer_id = $answer->id;
            $answerLang->lang_id = $lang->id;
            $answerLang->save();
        }

        return \Illuminate\Support\Facades\Redirect::to('poll/answer/edit/' . $answer->id);
    }

    public function edit_answer($id) {
        User::onlyHas('poll-edit');

        $data = array(
            'answer' => PollAnswerModel::find($id),
            'answer_langs' => PollAnswerLangModel::where('answer_id', $id)->get(),
            'module' => $this->module_name
        );

        $this->layout->content = Template::moduleView($this->module_name, 'views.answerform', $data);
        return $this->layout;
    }

    public function save_answer() {
        $answers = Input::get('answer');
        $answer_id = Input::get('answer_id');

        foreach ($answers as $anl_id => $ans) {
            $anw = PollAnswerLangModel::find($anl_id);
            if ($anw->answer_id == $answer_id) {
                $anw->title = $ans;
                $anw->save();
            }
        }

        return [];
    }

    public function delete_answer($id) {
        $answer = PollAnswerModel::find($id);
        $answer_id = 0;
        if ($answer) {
            $answer_id = $answer->poll_id;
            $answer->delete();
            PollAnswerLangModel::where('answer_id', $id)->delete();
            PollVotesModel::where('answer_id', $id)->delete();
        }

        return \Illuminate\Support\Facades\Redirect::to('poll/form/' . $answer_id);
    }

    /**
     * Edit / create poll
     * @param int $id
     * @return layout
     */
    public function form($id = 0) {
        User::onlyHas('poll-edit');

        $data = array(
            'poll' => PollModel::find($id),
            'poll_question' => array(),
            'module' => $this->module_name
        );

        if ($data['poll']) {
            $pollLangs = PollModel::find($id)->langs()->get();
            foreach ($pollLangs as $pollLang) {
                $data['poll_question'][$pollLang->lang_id] = $pollLang;
            }
        }


        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $data);
        return $this->layout;
    }

    /**
     * Save changes
     * @return array/json
     */
    public function save() {
        User::onlyHas('poll-edit');

        $id = Input::get('id');

        if ($id) {
            // if poll exists, find
            $poll = PollModel::find($id);
            if (!$poll) {
                throw Exception('Poll not found #' . $ic);
            }
        } else {
            // if poll does not exists, create new
            $poll = new PollModel();
        }

        $poll->enabled = (Input::get('enabled') == 'on') ? 1 : 0;
        $poll->active = (Input::get('active') == 'on') ? 1 : 0;
        $poll->save();

        if ($id) {
            return array(
                'error' => 0
            );
        } else {
            // if poll has been created, refresh page
            return array(
                'redirect_to' => url('poll/form/' . $poll->id)
            );
        }
    }

    /**
     * Save language changes
     * @return array/json
     */
    public function save_lang() {
        User::onlyHas('poll-edit');

        $poll_id = Input::get('poll_id');
        $poll_question_id = Input::get('poll_question_id');

        $redirect_to = '';

        if ($poll_question_id) {
            // if the poll-question exist, find
            $poll_question = PollQuestionModel::find($poll_question_id);
        } else {
            if (!$poll_id) {
                // if the poll does not exist, create empty poll record
                $poll = new PollModel();
                $poll->save();
                $new_poll_id = $poll->id;
                $redirect_to = url('poll/form/' . $new_poll_id);
            }

            // if the poll-question does not exist, create new
            $poll_question = new PollQuestionModel;
            $redirect_to = url('poll/form/' . $poll_id);
        }

        $poll_question->title = Input::get('question');
        $poll_question->poll_id = Input::get('poll_id');
        $poll_question->lang_id = Input::get('lang_id');
        $poll_question->save();

        if ($redirect_to) {
            // if poll has been created, refresh page
            return array(
                'redirect_to' => $redirect_to
            );
        }
    }

    /**
     * Edit item jqgrid
     */
    public function edititem($poll_question_id = 0) {
        User::onlyHas('poll-edit');

        $jqgrid = new jQgrid('apl_poll_answer');
        $jqgrid->operation(array(
            'title' => Input::get('answer'),
            'poll_question_id' => $poll_question_id
        ));
    }

    /**
     * Action for left menu
     */
    public function left_menu_item() {
        if (User::has('poll-view')) {
            echo Template::moduleView($this->module_name, 'views.poll-menu');
        }
    }

    public function poll_del($id = 0) {
        User::onlyHas('poll-edit');

        $questions = PollQuestionModel::where(array('poll_id' => $id))->get();

        PollModel::where(array('id' => $id))->delete();
        PollQuestionModel::where(array('poll_id' => $id))->delete();

        foreach ($questions as $question) {
            PollAnswerModel::where(array('poll_question_id' => $question->id))->delete();
        }

        return Redirect::to('poll/list');
    }

    public function language_created($lang_id) {
        $list = \PollModel::all();
        foreach ($list as $ent) {
            $item = new PollQuestionModel;
            $item->poll_id = $ent->id;
            $item->lang_id = $lang_id;
            $item->save();
        }
    }

    public function language_deleted($lang_id) {
        $list = PollQuestionModel::where('lang_id', $lang_id);
        foreach ($list as $item) {
            \PollAnswerModel::where('poll_question_id', $item->id);
            $item->delete();
        }
    }

}
