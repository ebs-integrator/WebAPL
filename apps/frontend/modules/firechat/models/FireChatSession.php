<?php

class FireChatSession extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_firechat';
    public $timestamps = false;

}
