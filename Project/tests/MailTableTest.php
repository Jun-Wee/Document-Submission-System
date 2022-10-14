<?php

use SystemFunction\{Database, MailTable};

class MailTableTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSubscribeConvenor() 
    {
        //requisite: convenors table (Jun Han; 101231636@student.swin.edu.au; isSubscribe=1) (Bao Quoc Vo; documentsubmissionsystem@hotmail.com; isSubscribe=1)
        $db = new Database();
        $mailtable = new MailTable($db);
        $subscriber = $mailtable->getSubscribeConvenor(); 

        $expect = array(array("Name" => "Jun Han", "Email" => "101231636@student.swin.edu.au"), array("Name" => "Bao Quoc Vo", "Email" => "documentsubmissionsystem@hotmail.com"));

        //print_r($expect);
        $this->assertEquals($expect, $subscriber);
    }

    public function testGetStudentInfo() 
    {
        //requisite: submission table only have one entry will isSendMail = 0 (10020; 101231636; Jun Wee; COS20001; 0)
        $db = new Database();
        $mailtable = new MailTable($db);

        $studentListByUnit = $mailtable->getStudentInfo("documentsubmissionsystem@hotmail.com", "COS20001");

        $expected= array(array( "UserId" => "101231636", "Name" => "Jun Wee", "unitCode" => "COS20001" , "SubmissionId" => "100056", "score" => "0"));

        print_r($expected);
        $this->assertEquals($expected, $studentListByUnit);
    }
    
    public function testGetConvenorUnit() 
    {
        //requisite: convenors table (Jun Han; 101231636@student.swin.edu.au; isSubscribe=1) 
        $db = new Database();
        $mailtable = new MailTable($db);
        $subscriberunit = $mailtable->getConvenorUnit("101231636@student.swin.edu.au"); 

        $expect = array(
            array("Name" => "Jun Han", "ConvenorEmail" => "101231636@student.swin.edu.au", "UnitCode" => "COS10005"), 
            array("Name" => "Jun Han", "ConvenorEmail" => "101231636@student.swin.edu.au", "UnitCode" => "COS10009"),
            array("Name" => "Jun Han", "ConvenorEmail" => "101231636@student.swin.edu.au", "UnitCode" => "ICT10001"),
            array("Name" => "Jun Han", "ConvenorEmail" => "101231636@student.swin.edu.au", "UnitCode" => "INF10002")
        );

        // print_r($subscriberunit);
        $this->assertEquals($expect, $subscriberunit);
    }

    public function testPrintInformation(){
        //requisite: submission table only have one entry will isSendMail = 0 (10020; 101231636; Jun Wee; COS20001; 0)
        $db = new Database();
        $mailtable = new MailTable($db);
        $studentListByUnit= $mailtable->getStudentInfo("documentsubmissionsystem@hotmail.com", "COS20001");
        $tableMsg = $mailtable->printInfomation("COS20001");
        
        $expect = '<table>';
        $expect .= '
        <h3>COS20001</h3>
        <tr>
        <th> Student Id</th>
        <th> Name </th>
        <th> Unit Code </th>
        <th> Submission Id </th>
        <th> Score </th>
        </tr>
        <tr><td style="padding: 15px;"> 101231636</td><td style="padding: 15px;"> Jun Wee</td><td style="padding: 15px;"> COS20001</td><td style="padding: 15px;"> 100056</td><td style="padding: 15px;"> 0</td></tr></table>';

        print_r($tableMsg);

        $this->assertEquals($expect, $tableMsg);
    }
}