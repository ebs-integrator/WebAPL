<?php

class JobRequestModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_job_requests';
    public $timestamps = false;

}