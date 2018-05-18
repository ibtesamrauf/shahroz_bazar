<?php
/**
 * Custom
 * Quincy Kwende <quincykwende@gmail.com>
 */

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\AdvertCategoryRequest as StoreRequest;
use App\Http\Requests\Admin\AdvertCategoryRequest as UpdateRequest;

class AdvertCategoryController extends PanelController
{   
    public function setup()
    {
       
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\AdvertCategory');
        $this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/advert_category');
        $this->xPanel->setEntityNameStrings(__t('advert_category'), __t('advert_categories'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // COLUMNS
        $this->xPanel->addColumn([
            'name'  => 'name',
            'label' => __t("Type"),
            'type'       => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
        $this->xPanel->addColumn([
            'name'  => 'width',
            'label' => __t("Width"),
            'type'       => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
        $this->xPanel->addColumn([
            'name'  => 'height',
            'label' => __t("Height"),
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
       
    }
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
