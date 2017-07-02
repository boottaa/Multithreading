<?php
/**
 * Created by PhpStorm.
 * User: boott
 * Date: 30.06.2017
 * Time: 21:00
 */

class Multithreading
{
    private
        $UidProcess = array(),
        $Priority = 0;

    /**
     * @param $Command
     * @param string $name
     * @return PID
     */
    public function run($Command, $name = '', $wait = false){
        if($wait){
            $wait_a = '';
        }else{
            $wait_a = '&';
        }

        if(!empty($this->Priority))
        {
            $PID = shell_exec("nice -n $this->Priority $Command > /dev/null $wait_a echo $!");
        }else{
            $PID = shell_exec("$Command > /dev/null $wait_a echo $!");
        }

        if(!empty($name)){
            addUid:
            if(!array_key_exists($name, $this->UidProcess))
            {
                $this->UidProcess[$name] = $PID;
            }else{
                $name .= "_";
                goto addUid;
            }
        }

        return $PID;
    }
    /**
     * Check if the Application running !
     *
     * @param     unknown_type $PID
     * @return     boolen
     */
    public function is_running($PID){
        exec("ps $PID", $ProcessState);
        return(count($ProcessState) >= 2);
    }
    /**
     * Kill Application PID
     *
     * @param  unknown_type $PID
     * @return boolen
     */
    public function kill($PID){
        if(exec::is_running($PID)){
            exec("kill -KILL $PID");
            return true;
        }else return false;
    }

    public function priority( int $num ){
        $this->Priority = $num;
        return $this;
    }

    public function getUidProcess($name = '')
    {
        $res = '';
        if($name == ''){
            $res = $this->UidProcess;
        }else{
            if(array_key_exists($name, $this->UidProcess)){
                $res = $this->UidProcess[$name];
            }
        }
        return $res;
    }

}