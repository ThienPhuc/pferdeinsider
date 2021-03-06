<?php
class Find_Member_Block_Member extends Mage_Core_Block_Template
{

	public function __construct()
	{ 
		parent::__construct();
                   
                      $data=$this->getRequest()->getParam('name');
                     
                        //$dataid=$data['searchproducts'];
                        $productModel = Mage::getModel('catalog/product');
                        $attr = $productModel->getResource()->getAttribute("member_list");

                        if ($attr->usesSource()) {
                          $id = $attr->getSource()->getOptionId($data);
                        }
                        
                      
             
                        $collection = Mage::getResourceModel('catalog/product_collection'); 
                        $_product=$collection->getData();
                       
                    
                        $attributes = Mage::getSingleton('catalog/config')
                            ->getProductAttributes();
                        
                        $collection->addAttributeToSelect($attributes)
                                    ->addStoreFilter();

                       
                        $collection->addFieldToFilter(array(
                            array('attribute'=>'member_list',array('eq'=>$id)),
                            ));
                      

                       /* $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')
                                    ->addFieldToFilter(
                                        array(
                                            array('attribute'=>'member_list','eq'=>'11'),

                                        )
                                    );*/
                       // echo "<pre>";print_r($collection->getData());die("DFgfd");
                      
                        $this->setCollection($collection);
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$parent_id = Mage::app()->getStore()->getRootCategoryId();
		if($this->getRequest()->getParam('category_id',false)){
			 $parent_id = $this->getRequest()->getParam('category_id');
		}
    
		$toolbar = $this->getToolbarBlock();
		// called prepare sortable parameters
		$collection = $this->getCollection();
                
		$toolbar->setCollection($collection);
                $this->setChild('toolbar', $toolbar);
		$this->getCollection()->load();
		return $this;
	}
	public function getDefaultDirection(){
		return 'asc';
	}
	public function getAvailableOrders(){
		return array('name'=> 'Name','position'=>'Position','children_count'=>'Sub Category Count');
	}
	public function getSortBy(){
		return 'name';
	}
	public function getToolbarBlock()
	{
		$block = $this->getLayout()->createBlock('member/toolbar', microtime());
		return $block;
	}
	public function getMode()
	{
		return $this->getChild('toolbar')->getCurrentMode();
	}

	public function getToolbarHtml()
	{
		return $this->getChildHtml('toolbar');
	}
}