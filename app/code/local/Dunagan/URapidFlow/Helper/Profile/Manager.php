<?php

class Dunagan_URapidFlow_Helper_Profile_Manager
{
    protected $_default_data = null;

    public function startProfile($profile)
    {
        try {
            switch ($profile->getRunStatus()) {
                case 'pending':
                    $profile->start()->save()->run();
                    $result = array('success'=>true);
                    break;
                case 'running':
                    $result = array('warning'=>Mage::helper('urapidflow')->__('The profile is already running'));
                    break;
                default:
                    $result = array('error'=>Mage::helper('urapidflow')->__('Invalid profile run status'));
            }
        } catch (Exception $e) {
            $result = array('error'=>$e->getMessage());
        }

        return $result;
    }

    public function setPendingProfile($profile)
    {
        $invokeStatus = 'ondemand';
        $profile->pending($invokeStatus)->save();
    }

    public function createProfile($data_type)
    {
        $model = Mage::getModel('urapidflow/profile');
        $model->setDataType($data_type);
        $model = $model->factory();

        $model = $this->addProfileSpecificData($model);

        return $model;
    }

    public function addProfileSpecificData($model)
    {
        $default_data = $this->_getDefaultDataArray();
        $model->addData($default_data);
        return $model;
    }

    protected function _getDefaultDataArray()
    {
        if (is_null($this->_default_data))
        {
            $this->_default_data = array();
        }

        return $this->_default_data;
    }
}
