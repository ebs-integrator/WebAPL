<?php

class Comments extends APL_Module {
    
    
    function __construct() {
        
    }
    
    // action()
    public function actionShowList($post_id) {
        // echo showlist
    }
    
    // action('comment/form', 21)
    public function actionForm($post_id) {
        // echo action form
    }
    
    // website.com/comments/save
    public function controllerSave($post_id) {
        // save comment
    }
    
    // website.com/comments/edit
    public function controllerEdit($comment_id) {
        // edit comment
    }
    
    // website.com/comments/more
    public function controllerMore($post_id) {
        // load view more-posts
        // echo all posts
    }
    
    
}