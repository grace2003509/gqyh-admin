<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/10/8
 * Time: 18:43
 */

namespace App\Services;

use SplObserver;
use SplSubject;
use Illuminate\Support\Facades\Log;

class ServicesObserver implements \SplObserver
{

    private $subject;

    public function update(SplSubject $subject)
    {
        //TODO: Implement update() method.

        $this->subject = $subject;

        //subject instance name
        $instance = $subject->instanceName;

        //method name
        $method   = $subject->methodName;


        Log::info('============= from service observers ===================');
        Log::info($instance.' --> '.$method);


        \Cache::flush();

        switch ($instance){
            case 'AdminPermissionService' :
                $this->permissionService();
                break;
            case 'ProjectService' :
                $this->projectService();
                break;
            case 'ProjectReportService' :

                break;
            case 'ProjectCommentService' :

                break;

            case 'ProjectOrderService' :

                break;
            case 'GroupService' :

                break;
            case 'CompanyService' :

                break;
            default :
                Log::info('============= from service observers2 ===================');
                Log::info($instance.' --> '.$method);
                break;
        }

    }


    private function permissionService(){

    }

    private function projectService(){

    }



}