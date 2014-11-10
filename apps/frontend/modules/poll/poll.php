<?php

/**
 *
 *
 * @author     Victor Vlas <victor.vlas@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    PollModel,
    Input,
    PollAnswerModel,
    PollQuestionModel,
    Language,
    PageView,
    Validator,
    SimpleCapcha,
    Route,
    Redirect;

class Poll extends \WebAPL\ExtensionController {

    protected $module_name = 'poll';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PollModel'));

        Template::registerViewMethod('page', 'pollList', 'Lista de sondaje', array($this, 'pollList'), true);
        Route::post('poll/register', array($this, 'pollRegister'));

        \WebAPL\Shortcodes::register('poll', array($this, 'pollShortcode'));
    }

    public function pollList($data) {
        $wdata['page_url'] = $data['page_url'];

        $item = intval(Input::get('item'));
        if ($item) {
            $wdata['poll'] = PollModel::getByID($item);
            if (!$wdata['poll']) {
                throw new Exception("Poll not found #{$item}");
            }
        } else {
            $wdata['poll'] = PollModel::getLast();
            if (!$wdata['poll']) {
                throw new Exception("Polls not found");
            }
        }

        $wdata['voted'] = PollModel::ivoted($wdata['poll']->id);

        if ($wdata['voted']) {
            $wdata['poll'] = PollModel::getWithVotes($wdata['poll']->id);
        }

        $wdata['polls'] = PollModel::getList($wdata['poll']->id);

        if ($wdata['poll']) {
            Template::setPageTitle($wdata['poll']->title, true);
        }

        $data['page']->text .= Template::moduleView($this->module_name, 'views.pollList', $wdata);

        return PageView::defaultView($data);
    }

    public function pollRegister() {
        $id = Input::get('id');
        $answer_id = Input::get('poll_answer');
        $capcha = Input::get('capcha');

        $validator = Validator::make(array(
                    'id' => $id,
                    varlang('poll-raspunsuri') => $answer_id,
                    'capcha' => SimpleCapcha::valid('poll', $capcha) ? 1 : null
                        ), array(
                    'id' => 'required',
                    varlang('poll-raspunsuri') => 'required',
                    'capcha' => 'required'
        ));

        $return = array(
            'message' => '',
            'error' => 0,
            'html' => ''
        );

        if ($validator->fails()) {
            $return['message'] = implode(' ', $validator->messages()->all('<p>:message</p>'));
            $return['error'] = 1;
        } else {

            $wdata = array(
                'poll' => PollModel::getWithVotes($id),
                'answer' => PollAnswerModel::join(PollModel::getTableName(), PollModel::getField('id'), '=', PollAnswerModel::getField('poll_id'))
                        ->where(PollAnswerModel::getField('poll_id'), $id)
                        ->first(),
                'total_votes' => \PollVotesModel::where('poll_id', $id)->count()
            );

            if ($wdata['poll'] && $wdata['answer']) {
                if (!PollModel::ivoted($id)) {
                    SimpleCapcha::destroy('poll');

                    $vote = new \PollVotesModel;
                    $vote->poll_id = $wdata['poll']->id;
                    $vote->answer_id = $answer_id;
                    $vote->ip = \Request::getClientIp();
                    $vote->save();

                    \Cookie::queue('voted_id_' . $wdata['poll']->id, '1', 3600);

                    $return['html'] = Template::moduleView($this->module_name, 'views.pollResults', $wdata)->render();
                } else {
                    $return['message'] = varlang('you-have-already-voted');
                    $return['error'] = 1;
                }
            } else {
                $return['message'] = varlang('poll-not-found');
                $return['error'] = 1;
            }
        }

        return $return;
    }

    public function pollShortcode($params) {
        $wdata['poll'] = PollModel::getWithVotes($params['id']);

        if (!$wdata['poll']) {
            throw new Exception("Poll not found #{$params['id']}");
        }

        if (PollModel::ivoted($params['id'])) {
            $wdata['total_votes'] = \PollVotesModel::where('poll_id', $wdata['poll']->id)->count();

            return Template::moduleView($this->module_name, 'views.pollResults', $wdata);
        } else {
            return Template::moduleView($this->module_name, 'views.pollItem', $wdata);
        }
    }

}
