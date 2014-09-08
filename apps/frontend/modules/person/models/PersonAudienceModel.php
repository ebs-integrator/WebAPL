<?php

class PersonAudienceModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_person_audience';
    public $timestamps = false;
    
}