<?php

/**
 *
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */
class SettingsController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $taxonomy;
    protected $layout = 'layout.main';

    public function getIndex() {
        User::onlyHas("settings-view");

        $this->data['setts'] = SettingsModel::getAll();
        
        $this->layout->content = View::make('sections.settings.edit', $this->data);
    }

    public function postSave() {
        $settings = Input::get('set');

        if (is_array($settings)) {
            foreach ($settings as $key => $set) {
                $sett = SettingsModel::find($key);
                if (!$sett) {
                    $sett = new SettingsModel;
                    $sett->key = $key;
                }
                $sett->value = $set;
                $sett->save();
            }
        }
        
        Log::info('Edit settings');
        
        return [];
    }

}