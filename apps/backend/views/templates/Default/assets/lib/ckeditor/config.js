/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
    config.uiColor = '#4eb25c';
    
    config.removePlugins = 'about,save,forms';
    config.extraPlugins = 'texttransform,wordcount,oembed';
    config.height = 400;

    config.colorButton_colors = '7c4d7c,4c4c4c,b6c57e,74b45a';

    config.wordcount = {
        showWordCount: true,
        showCharCount: true,
        countHTML: false,
        charLimit: 'unlimited',
        wordLimit: 'unlimited'
    };
};
