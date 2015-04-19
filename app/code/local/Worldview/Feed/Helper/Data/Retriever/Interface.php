<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * interface Worldview_Feed_Helper_Data_Retriever_Interface
 */

interface Worldview_Feed_Helper_Data_Retriever_Interface
    extends Dunagan_Base_Model_Delegate_Interface
{
    /**
     * @param Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection
     * @return array - Some array of data fields regarding the articles. The indexes of the array should refer to the codes
     *                  of the sources which the articles were fed from. Creating the article Objects and persisting them to the
     *                  database is another delegate's responsibility
     */
    public function retrieveDataFromSourceCollection(Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection);
}
