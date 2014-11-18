<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 
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
