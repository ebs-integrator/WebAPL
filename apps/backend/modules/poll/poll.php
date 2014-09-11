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
    Language,
    Redirect,
    jQgrid;

class Poll extends \Core\APL\ExtensionController {

    protected $module_name = 'poll';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PollModel'));

        Actions::get('poll/list', array('before' => 'auth', array($this, 'poll_list')));
        Actions::post('poll/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::get('poll/form', array('before' => 'auth', array($this, 'form')));
        Actions::get('poll/form/{id}', array('before' => 'auth', array($this, 'form')));
        Actions::post('poll/save', array('before' => 'auth', array($this, 'save')));
        Actions::post('poll/save_lang', array('before' => 'auth', array($this, 'save_lang')));
        Actions::post('poll/edititem', array('before' => 'auth', array($this, 'edititem')));
        Actions::post('poll/edititem/{poll_lang_id}', array('before' => 'auth', array($this, 'edititem')));
        Actions::post('poll/add', array('before' => 'auth', array($this, 'poll_add')));

        Actions::get('poll/del', array('before' => 'auth', array($this, 'poll_del')));
        Actions::get('poll/del/{id}', array('before' => 'auth', array($this, 'poll_del')));

        Actions::post('poll/list/answer', array('before' => 'auth', array($this, 'getlist_answer')));
        Actions::post('poll/list/answer/{poll_lang_id}', array('before' => 'auth', array($this, 'getlist_answer')));

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        Template::registerViewMethod('page', 'pollList', 'Lista de sondaje', null, true);
        
        $this->layout = Template::mainLayout();
    }

    /**
     * jqgrid view with polls list
     * @return layout
     */
    public function poll_list() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    /**
     * get list of polls for jqgrid
     * @return json
     */
    public function getlist() {
        $jqgrid = new jQgrid('apl_poll');
        return $jqgrid->populate(function($start, $limit) {
                    return PollModel::select('apl_poll.id', 'apl_poll_question.title', 'author_id', 'date_created', 'enabled')
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
        $jqgrid = new jQgrid('apl_poll_answer');
        return $jqgrid->populate(function($start, $limit) use($poll_lang_id) {
                    return PollAnswerModel::select('id', 'title')
                                    ->skip($start)
                                    ->take($limit)
                                    ->where(array('poll_question_id' => $poll_lang_id))
                                    ->get();
                });
    }

    /**
     * Edit / create poll
     * @param int $id
     * @return layout
     */
    public function form($id = 0) {
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
        echo Template::moduleView($this->module_name, 'views.poll-menu');
    }

    public function poll_del($id = 0) {
        $questions = PollQuestionModel::where(array('poll_id' => $id))->get();

        PollModel::where(array('id' => $id))->delete();
        PollQuestionModel::where(array('poll_id' => $id))->delete();

        foreach ($questions as $question) {
            PollAnswerModel::where(array('poll_question_id' => $question->id))->delete();
        }

        return Redirect::to('poll/list');
    }

}
