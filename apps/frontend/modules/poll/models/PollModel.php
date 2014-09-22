<?php

class PollModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_poll';
    public static $ftable = 'apl_poll'; // public table name
    public $timestamps = false;

    public function langs() {
        return $this->hasMany('PollQuestionModel', 'poll_id', 'id');
    }

    public static function prepare() {
        return PollModel::join(PollQuestionModel::getTableName(), PollModel::getField('id'), '=', PollQuestionModel::getField('poll_id'))
                        ->where(PollQuestionModel::getField('lang_id'), '=', \Core\APL\Language::getId())
                        ->where(PollModel::getField('enabled'), '=', 1)
                        ->select(PollModel::getField('date_created'), PollQuestionModel::getField('title'), DB::raw(PollQuestionModel::getField('id') . " as poll_question_id"), PollModel::getField('id'), PollModel::getField('active'));
    }
    
    public static function getWithVotes($id) {
        $poll = PollModel::getByID($id);
        
        if ($poll) {
            foreach ($poll->answers as &$answer) {
                $answer->count = PollVotesModel::where(array(
                    'poll_id' => $id,
                    'answer_id' => $answer->id
                ))->count();
            }
        }
        
        return $poll;
    }

    public static function getByID($id) {
        $poll = PollModel::prepare()->where(PollModel::getField('id'), $id)->get()->first();

        if ($poll) {
            $poll->answers = PollAnswerModel::where('poll_question_id', $poll->poll_question_id)->get();
        }

        return $poll;
    }

    public static function getLast() {
        $poll = PollModel::prepare()->orderBy('date_created', 'desc')->get()->first();

        if ($poll) {
            $poll->answers = PollAnswerModel::where('poll_question_id', $poll->poll_question_id)->get();
        }

        return $poll;
    }

    public static function getList($different_id = 0) {
        $polls = PollModel::prepare();

        if ($different_id) {
            $polls = $polls->where(PollModel::getField('id'), '<>', $different_id);
        }

        return $polls->paginate(10);
    }
    
    public static function ivoted($poll_id) {
        $ck_voted = Cookie::get('voted_id_'.$poll_id);
        $ip_voted = PollVotesModel::where('ip', Request::getClientIp())->where('poll_id', $poll_id)->count();

        return $ck_voted || ($ip_voted > 20);
    }

}
