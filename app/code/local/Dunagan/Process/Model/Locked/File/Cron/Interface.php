<?php

interface Dunagan_Process_Model_Locked_File_Cron_Interface
    extends Dunagan_Process_Model_Locked_File_Interface, Dunagan_Process_Model_Locked_Cron_Interface
{
    public function getLockFileDirectory();

    public function getLockFileName();
}
