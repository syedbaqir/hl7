<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aranyasen\HL7\Message; // If Message is used
use Aranyasen\HL7\Segment; // If Segment is used
use Aranyasen\HL7\Segments\PID; // If Segment is used
use Aranyasen\HL7\Segments\IN1;
use Aranyasen\HL7\Segments\MSH; // If MSH is used
use Aranyasen\HL7\Segments\OBR;
use Aranyasen\HL7\Segments\ORC; // If MSH is used
use Aranyasen\HL7\Segments\DG1; // If MSH is used

class HomeController extends Controller
{
    
    public function index(Request $request)
    {

       
        if($request->all()!=null)
        {
            $first=$request['First'];
            $last=$request['Last'];
            $ID=$request['ID'];
            $Number=$request['Number'];
            $Birth=$request['Birth'];
            $Place=$request['Place'];
            $Gander=$request['Gander'];
            $Marital=$request['Marital'];
            $Address=$request['Address'];
            $Birth=date("d", strtotime($Birth));
        
            $msg = new Message("MSH|^~\&|||||||ORM^O01||P|2.3.1|", null, true, true);
            $pid = new PID();  
            $pid->setPatientName([$first,$last]); 
            $pid->setPatientID($ID);
            $pid->setPhoneNumberBusiness($Number);
            $pid->setDateTimeOfBirth($Birth);
            $pid->setNationality($Place);        
            $pid->setSex($Gander);
            $pid->setMaritalStatus($Marital);
            $pid->setPatientAddress($Address);        
            $msg->addSegment($pid,1);

            $getData=$msg->hasSegment('PID');
            $data4=$msg->toString();
            //$data=base64_decode($msg->toString());
            //dd(base64_encode($data));

            return view("welcome",compact('data4'));

        }
        else{




        //Create a Message object from a HL7 string
        $msg = new Message("MSH|^~\\&|1|\rPID|||SyedBaqirRaza|\r"); // Either \n or \r can be used as segment endings
        $pid = $msg->getSegmentByIndex(1);
        $data1=$pid->getField(3); // prints 'abcd'
        $data2=$msg->toString(true); // Prints entire HL7 string
        //Get the first segment
        $msg->getFirstSegmentInstance('PID'); // Returns the first PID segment. Same as $msg->getSegmentsByName('PID')[0];
        //Check if a segment is present in the message object
        $data3=$msg->hasSegment('PID'); // return true or false based on whether PID is present in the $msg object
        //Check if a message is empty
        $msg = new Message();
        $msg->isempty(); // Returns true
        //Create an empty Message object, and populate MSH and PID segments... 
        $msg = new Message();
        $msh = new MSH();
        $msg->addSegment($msh); // Message is: "MSH|^~\&|||||20171116140058|||2017111614005840157||2.3|\n"


        // Create any custom segment
        $abc = new Segment('ABC');
        $abc->setField('1', 'xyz');
        $abc->setField('2', 'abc');
        $abc->setField('3', 'def');
        $abc->setField('4', ['syed','baqir','raza','naqvi']); // Set an empty field at 4th position. 2nd and 3rd positions will be automatically set to empty
        //$abc->clearField(2); // Clear the value from field 2

        
        $msg->setSegment($abc, 1); // Message is now: "MSH|^~\&|||||20171116140058|||2017111614005840157||2.3|\nABC|xyz|\n"
        $msg->addSegment($msh);
        //dd($msg);
        // Create a defined segment (To know which segments are defined in this package, look into Segments/ directory)
        // Advantages of defined segments over custom ones (shown above) are 1) Helpful setter methods, 2) Auto-incrementing segment index 
        $pid = new PID(); // Automatically creates PID segment, and adds segment index at PID.1
        $pid->setPatientName(['baqir', 'syed', 'raza', 'naqvi']); // Use a setter method to add patient's name at standard position (PID.5)
        $pid->setField(1,'murshad'); // Apart from standard setter methods, you can manually set a value at any position too
        
        $msg->setSegment($pid, 1); // Message is now: "MSH|^~\&|||||20171116140058|||2017111614005840157||2.3|\nABC|xyz|\n"
        $msg->addSegment($msh);


       /// dd($pid);
        unset($pid); // Destroy the segment and decrement the id number. Useful when you want to discard a segment.     


        return view("welcome",compact('data1','data2'));
        }
        
}
public function hl7(Request $request)
{
    if($request['data']!=null)
    {
    
        
        $hl7Data=$request['data'];
        $hl7Data=base64_decode($hl7Data);   
        $msg = new Message(stripcslashes($hl7Data));    
        $pid=$msg->getSegmentsByName('PID')[0];     
        $patientName=$pid->getPatientName();
        $getSex=$pid->getSex();
        $getID=$pid->getID();
        $getMaritalStatus=$pid->getMaritalStatus();
        $getNationality=$pid->getNationality();
        $getPatientAddress=$pid->getPatientAddress();
        $getPatientID=$pid->getPatientID();
        $getPhoneNumberBusiness=$pid->getPhoneNumberBusiness();
        $getDateTimeOfBirth=$pid->getDateTimeOfBirth();   
        
        
        //$hl7String = "MSH|^~\&|||||||ORU^R01|00001|P|2.3.1|\n" . "OBX|1||11^AA|\n" . "OBX|1||22^BB|\n";
        //$msg = new Message($hl7String, null, true, true, false);
        //dd($msg->toString(true));
        // dd( $getBirthOrder=$pid->getBirthOrder());
        //  dd( $getBirthPlace=$pid->getBirthPlace());
        // dd( $getCitizenship=$pid->getCitizenship());
        //$sd=explode(PHP_EOL,$hl7Data);
        //$skuList = preg_split("/\r\n|\r|\n/", $hl7Data);
        //dd($skuList); 
        //dd($hl7Data);
        //$data="TVNIfF5+XCZ8fHx8fHx8T1JNXk8wMXx8UHwyLjMuMXxcblBJRHwxfDExfHx8c3llZF5iYXFpcnx8fE18fHxrYXJhY2hpfHx8MDM0NjE2NTIzNTF8fHNpbmdsZXx8fHx8fHx8fHx8fGd1anJhbndhbGF8MDF8XG4=";//$request['data'];
        //$hl7Data="MSH|^~\&|EPIC|EPICFACILITY|ECLINICALWORKS|ECWFACILITY|202106030432||ADT^A31|4479455|T|2.3\nEVN|A31|202106030432|||\nPID||7707|7707||MANTE^ODA^^I||19531019|F||2106-3|80470 KIHN GROVE^APT. 279^SOUTH WAYNE^MN^54533-4000||781-858-4217|491-363-4272|eng^English|S||PATID7707^1^M10|437-584-9296|78861291^MN||2106-3^\nPD1||||A99561^HANE^IGNATIUS\nNK1|1|TOY^PARKER^Z|FND||||N\nNK1|2|TREVER^WELCH^O|EME||||C\nPV1||I|3000^2021^01||||609^SPORER^SHAYNE|48749^O'HARA^CANDICE|||||||||\nGT1|1|2011|ANGELINA^NOLAN^J||1|1||19531019|||||||||||||||||||||||||||||||||||||ADELIA LABADIE|491-363-4272||\nIN1|1|847765|853986|MEDICAID|PO BOX 740800^^ATLANTA^GA^30374-0800||(877)842-3210|95446|||ATHENA||||C1|LASTNAME^FIRSTNAME^MIDDLENNAME|Self|19880601|ADDRESS^ADDRESS (CTD)^BRIGHTON^MA^02135^1^000000000|||1||||20150409||||||||||12345|||||||M";
        //$hl7Data="MSH|^~\&|EPIC|EPICFACILITY|ECLINICALWORKS|ECWFACILITY|202106030432||ADT^A31|4479455|T|2.3.1\nPID|1|12|||baqir^raza|||M|||karachi|||03461652351||single||||||||||||gujranwala|01|\n";
        //$ddd=nl2br($hl7Data);
        // $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $hl7Data);
        // $ddd=str_replace("\n","",$hl7Data);
        //dd(is_string($hl7Data));
        //$msg = new Message("MSH|^~\&|||||||ORM^O01||P|2.3.1|\nPID|1|12|||baqir^raza|||M|||karachi|||03461652351||single||||||||||||gujranwala|01|\n");
        // $msg = new Message($string,['SEGMENT_SEPARATOR' => '\n', 'HL7_VERSION' => '2.3.1']);
        // dd( $getMothersIdentifier=$pid->getMothersIdentifier());
        // dd( $getCountryCode=$pid->getCountryCode());
        // dd($getMothersMaidenName=$pid->getMothersMaidenName());
        // dd($getMultipleBirthIndicator=$pid->getMultipleBirthIndicator());    
        // dd($getPatientAccountNumber=$pid->getPatientAccountNumber());   
        // dd($getPatientAlias=$pid->getPatientAlias());   
        // dd($getPatientIdentifierList=$pid->getPatientIdentifierList());    
        // dd( $getPhoneNumberHome=$pid->getPhoneNumberHome());
        // dd($getPrimaryLanguage=$pid->getPrimaryLanguage());
        // dd($getRace=$pid->getRace());
        // dd($getReligion=$pid->getReligion());
        // dd($getSSNNumber=$pid->getSSNNumber());    
        // dd($getVeteransMilitaryStatus=$pid->getVeteransMilitaryStatus());
        // dd($getAlternatePatientID=$pid->getAlternatePatientID());
        // dd($hl7Data);
        // dd($msg->getSegmentAsString(0));
        // $pid=$msg->getSegmentsByName('PID');
        // dd($pid); 
        // dd(print_r($allSegment)); 
        // $first=$msg->getFirstSegmentInstance('PID');    
        // $dd=$msg->getSegmentsByName('PID');
        // dd($dd);
        // $dd=$msg->hasSegment('PID');
        // dd($first);

    return view("hltotext",compact('patientName','Sex','ID','MaritalStatus','Nationality','PatientAddress','PatientID','PhoneNumberBusiness','DateTimeOfBirth'));
        

    
    }
    else{
        return view("hltotext");
    }

}
public function getFile()
{
    $pidData=[];
    $in2Data=[];
    $gt1Data=[];
    $orcData=[];
    $msg = new Message(file_get_contents('https://softvrbox.com/sampleorder.hl7'));   
    
    // dd($msg);
    $pid=new PID();
    $pid = $msg->getSegmentsByName('PID')[0];

    $pidData['Patient Name']=$pid->getPatientName();    
    $pidData['Gander']=$pid->getSex();
    $pidData['ID']=$pid->getID();
    $pidData['Marital Status']=$pid->getMaritalStatus();
    $pidData['Nationality']=$pid->getNationality();
    $pidData['Patient Address']=$pid->getPatientAddress();
    $pidData['Patient ID']=$pid->getPatientID();
    $pidData['Phone Number Business']=$pid->getPhoneNumberBusiness();
    $pidData['Date Time Of Birth']=$pid->getDateTimeOfBirth(); 
    $pidData['Mothers Identifier']=$pid->getMothersIdentifier();
    $pidData['Country Code']=$pid->getCountryCode();
    $pidData['Mothers Maiden Name']=$pid->getMothersMaidenName();
    $pidData['Multiple Birth Indicator']=$pid->getMultipleBirthIndicator();    
    $pidData['Patient Account Number']=$pid->getPatientAccountNumber();   
    $pidData['Patient Alias']=$pid->getPatientAlias();   
    $pidData['Patient Identifier List']=$pid->getPatientIdentifierList();    
    $pidData['Phone Number Home']=$pid->getPhoneNumberHome();
    $pidData['Primary Language']=$pid->getPrimaryLanguage();
    $pidData['Race']=$pid->getRace();
    $pidData['Religion']=$pid->getReligion();
    $pidData['SSN Number']=$pid->getSSNNumber();    
    $pidData['Veterans Military Status']=$pid->getVeteransMilitaryStatus();
    $pidData['Alternate Patient ID']=$pid->getAlternatePatientID(); 

    $in1=new IN1();
    $in1 = $msg->getSegmentsByName('IN1')[0];

    $in2Data['Assignment Of Benefits']=$in1->getAssignmentOfBenefits();
    $in2Data['Authorization Information']=$in1->getAuthorizationInformation();
    $in2Data['Billing Status']=$in1->getBillingStatus();
    $in2Data['Company Plan Code']=$in1->getCompanyPlanCode();
    $in2Data['Coord Of Ben Priority']=$in1->getCoordOfBenPriority();
    $in2Data['Coordination Of Benefits']=$in1->getCoordinationOfBenefits();
    $in2Data['Coverage Type']=$in1->getCoverageType();
    $in2Data['Delay Before LR Day']=$in1->getDelayBeforeLRDay();
    $in2Data['Group Name']=$in1->getGroupName();
    $in2Data['Group Number']=$in1->getGroupNumber();
    $in2Data['Handicap']=$in1->getHandicap();
    $in2Data['ID']=$in1->getID();
    $in2Data['Insurance Co Contact Person']=$in1->getInsuranceCoContactPerson();
    $in2Data['Insurance Co Phone Number']=$in1->getInsuranceCoPhoneNumber();
    $in2Data['Insurance Company Address']=$in1->getInsuranceCompanyAddress();
    $in2Data['Insurance Company ID']=$in1->getInsuranceCompanyID();
    $in2Data['Insurance Company Name']=$in1->getInsuranceCompanyName();
    $in2Data['Insurance Plan ID']=$in1->getInsurancePlanID();
    $in2Data['Insureds Address']=$in1->getInsuredsAddress();
    $in2Data['Insureds Date Of Birth']=$in1->getInsuredsDateOfBirth();
    $in2Data['Insureds Employers Address']=$in1->getInsuredsEmployersAddress();
    $in2Data['Insureds Employment Status']=$in1->getInsuredsEmploymentStatus();
    $in2Data['Insureds Group Emp ID']=$in1->getInsuredsGroupEmpID();
    $in2Data['Insureds Group Emp Name']=$in1->getInsuredsGroupEmpName();
    $in2Data['Insureds ID Number']=$in1->getInsuredsIDNumber();
    $in2Data['Insureds Relationship To Patient']=$in1->getInsuredsRelationshipToPatient();
    $in2Data['Insureds Sex']=$in1->getInsuredsSex();
    $in2Data['Lifetime Reserve Days']=$in1->getLifetimeReserveDays();
    $in2Data['Name Of Insured']=$in1->getNameOfInsured();
    $in2Data['Notice Of Admission Date']=$in1->getNoticeOfAdmissionDate();
    $in2Data['Notice Of Admission Flag']=$in1->getNoticeOfAdmissionFlag();
    $in2Data['Plan Effective Date']=$in1->getPlanEffectiveDate();
    $in2Data['Plan Expiration Date']=$in1->getPlanExpirationDate();
    $in2Data['Plan Type']=$in1->getPlanType();
    $in2Data['Policy Deductible']=$in1->getPolicyDeductible();
    $in2Data['Policy Limit Amount']=$in1->getPolicyLimitAmount();
    $in2Data['Policy Limit Days']=$in1->getPolicyLimitDays();
    $in2Data['Policy Number']=$in1->getPolicyNumber();
    $in2Data['Pre Admit Cert PAC']=$in1->getPreAdmitCertPAC();
    $in2Data['Prior Insurance Plan ID']=$in1->getPriorInsurancePlanID();
    $in2Data['Release Information Code']=$in1->getReleaseInformationCode();
    $in2Data['Report Of Eligibility Date']=$in1->getReportOfEligibilityDate();
    $in2Data['Report Of Eligibility Flag']=$in1->getReportOfEligibilityFlag();
    $in2Data['Room Rate Private']=$in1->getRoomRatePrivate();
    $in2Data['Room Rate Semi Private']=$in1->getRoomRateSemiPrivate();
    $in2Data['Type Of Agreement Code']=$in1->getTypeOfAgreementCode();
    $in2Data['Verification By']=$in1->getVerificationBy();
    $in2Data['Verification Date Time']=$in1->getVerificationDateTime();
    $in2Data['Verification Status']=$in1->getVerificationStatus();

   // $gt1=new GT1();
    $gt1 = $msg->getSegmentsByName('GT1')[0];

    $gt1Data['Set ID']=$gt1->getField(0);
    $gt1Data['Guarantor Number']=$gt1->getField(1);
    $gt1Data['Guarantor Name']=$gt1->getField(2);
    $gt1Data['Guarantor Spouse Name']=$gt1->getField(3);
    $gt1Data['Guarantor Address']=$gt1->getField(4);
    $gt1Data['Guarantor Ph Num - Home']=$gt1->getField(5);
    $gt1Data['Guarantor Ph Num - Business']=$gt1->getField(6);
    $gt1Data['Guarantor Date/Time Of Birth']=$gt1->getField(7);
    $gt1Data['Guarantor Administrative Sex']=$gt1->getField(8);
    $gt1Data['Guarantor Type']=$gt1->getField(9);
    $gt1Data['Guarantor Relationship']=$gt1->getField(10);
  
    $orc=new ORC();
    $orc = $msg->getSegmentsByName('ORC')[0];

    $orcData['ActionBy']=$orc->getActionBy();	
    $orcData['AdvancedBeneficiaryNoticeCode']=$orc->getAdvancedBeneficiaryNoticeCode();
    $orcData['AdvancedBeneficiaryNoticeOverrideReason']=$orc->getAdvancedBeneficiaryNoticeOverrideReason();
    $orcData['CallBackPhoneNumber']=$orc->getCallBackPhoneNumber();
    $orcData['ConfidentialityCode']=$orc->getConfidentialityCode();
    $orcData['DateTimeofTransaction']=$orc->getDateTimeofTransaction();
    $orcData['EnteredBy']=$orc->getEnteredBy();
    $orcData['EntererAuthorizationMode']=$orc->getEntererAuthorizationMode();
    $orcData['EnterersLocation']=$orc->getEnterersLocation();
    $orcData['EnteringDevice']=$orc->getEnteringDevice();
    $orcData['EnteringOrganization']=$orc->getEnteringOrganization();
    $orcData['FillerOrderNumber']=$orc->getFillerOrderNumber();
    $orcData['FillersExpectedAvailabilityDateTime']=$orc->getFillersExpectedAvailabilityDateTime();
    $orcData['OrderControl']=$orc->getOrderControl();
    $orcData['OrderControlCodeReason']=$orc->getOrderControlCodeReason();
    $orcData['OrderEffectiveDateTime']=$orc->getOrderEffectiveDateTime();
    $orcData['OrderStatus']=$orc->getOrderStatus();
    $orcData['OrderStatusModifier']=$orc->getOrderStatusModifier();
    $orcData['OrderType']=$orc->getOrderType();
    $orcData['OrderingFacilityAddress']=$orc->getOrderingFacilityAddress();
    $orcData['OrderingFacilityName']=$orc->getOrderingFacilityName();
    $orcData['OrderingFacilityPhoneNumber']=$orc->getOrderingFacilityPhoneNumber();
    $orcData['OrderingProvider']=$orc->getOrderingProvider();
    $orcData['OrderingProviderAddress']=$orc->getOrderingProviderAddress();
    $orcData['ParentOrder']=$orc->getParentOrder();
    $orcData['ParentUniversalServiceIdentifier']=$orc->getParentUniversalServiceIdentifier();
    $orcData['PlacerGroupNumber']=$orc->getPlacerGroupNumber();
    $orcData['PlacerOrderNumber']=$orc->getPlacerOrderNumber();
    $orcData['QuantityTiming']=$orc->getQuantityTiming();
    $orcData['ResponseFlag']=$orc->getResponseFlag();
    $orcData['VerifiedBy']=$orc->getVerifiedBy();

    $obr=new OBR();
    $obr = $msg->getSegmentsByName('OBR')[0];
    
    


    $obrData['Assistant Result Interpreter']=$obr->getAssistantResultInterpreter();	
    $obrData['Chargeto Practice']=$obr->getChargetoPractice();
    $obrData['Collection Volume']=$obr->getCollectionVolume();
    $obrData['Collector Identifier']=$obr->getCollectorIdentifier();
    $obrData['Collectors Comment']=$obr->getCollectorsComment();
    $obrData['Danger Code']=$obr->getDangerCode();
    $obrData['Diagnostic Serv Sect ID']=$obr->getDiagnosticServSectID();
    $obrData['Escort Required']=$obr->getEscortRequired();
    $obrData['Filler Field 1']=$obr->getFillerField1();
    $obrData['Filler Field 2']=$obr->getFillerField2();
    $obrData['Filler Order Number']=$obr->getFillerOrderNumber();
    $obrData['ID']=$obr->getID();
    $obrData['Number of Sample Containers']=$obr->getNumberofSampleContainers();
    $obrData['Observation Date Time']=$obr->getObservationDateTime();
    $obrData['Observation End Date Time']=$obr->getObservationEndDateTime();
    $obrData['Order Callback Phone Number']=$obr->getOrderCallbackPhoneNumber();
    $obrData['Ordering Provider']=$obr->getOrderingProvider();
    $obrData['Parent']=$obr->getParent();
    $obrData['Parent Result']=$obr->getParentResult();
    $obrData['Placer Order Number']=$obr->getPlacerOrderNumber();
    $obrData['Placer field 1']=$obr->getPlacerfield1();
    $obrData['Placer field 2']=$obr->getPlacerfield2();
    $obrData['Planned Patient Transport Comment']=$obr->getPlannedPatientTransportComment();
    $obrData['Principal Result Interpreter']=$obr->getPrincipalResultInterpreter();
    $obrData['Priority']=$obr->getPriority();
    $obrData['Quantity Timing']=$obr->getQuantityTiming();
    $obrData['Reason for Study']=$obr->getReasonforStudy();
    $obrData['Relevant Clinical Info']=$obr->getRelevantClinicalInfo();
    $obrData['Requested Date time']=$obr->getRequestedDatetime();
    $obrData['Result Copies To']=$obr->getResultCopiesTo();
    $obrData['Result Status']=$obr->getResultStatus();
    $obrData['Results Rpt Status Chng Date Time']=$obr->getResultsRptStatusChngDateTime();
    $obrData['Scheduled Date Time']=$obr->getScheduledDateTime();
    $obrData['Specimen Action Code']=$obr->getSpecimenActionCode();
    $obrData['Specimen Received Date Time']=$obr->getSpecimenReceivedDateTime();
    $obrData['Specimen Source']=$obr->getSpecimenSource();
    $obrData['Technician']=$obr->getTechnician();
    $obrData['Transcriptionist']=$obr->getTranscriptionist();
    $obrData['Transport Arranged']=$obr->getTransportArranged();
    $obrData['Transport Arrangement Responsibility']=$obr->getTransportArrangementResponsibility();
    $obrData['Transport Logistics of Collected Sample']=$obr->getTransportLogisticsofCollectedSample();
    $obrData['Transportation Mode']=$obr->getTransportationMode();
    $obrData['Universal Service ID']=$obr->getUniversalServiceID();

    $dg1=new DG1();
    $dg1 = $msg->getSegmentsByName('DG1')[0];

    $dg1Data['Attestation Date Time']=$dg1->getAttestationDateTime();	
    $dg1Data['Confidential Indicator']=$dg1->getConfidentialIndicator();	
    $dg1Data['DRG Approval Indicator']=$dg1->getDRGApprovalIndicator();	
    $dg1Data['DRG Grouper Review Code']=$dg1->getDRGGrouperReviewCode();	
    $dg1Data['Diagnosing Clinician']=$dg1->getDiagnosingClinician();	
    $dg1Data['Diagnosis Classification']=$dg1->getDiagnosisClassification();	
    $dg1Data['Diagnosis Code DG1']=$dg1->getDiagnosisCodeDG1();	
    $dg1Data['Diagnosis Coding Method']=$dg1->getDiagnosisCodingMethod();	
    $dg1Data['Diagnosis Date Time']=$dg1->getDiagnosisDateTime();	
    $dg1Data['Diagnosis Description']=$dg1->getDiagnosisDescription();	
    $dg1Data['Diagnosis Priority']=$dg1->getDiagnosisPriority();	
    $dg1Data['Diagnosis Type']=$dg1->getDiagnosisType();	
    $dg1Data['Diagnostic Related Group']=$dg1->getDiagnosticRelatedGroup();	
    $dg1Data['Grouper Version And Type']=$dg1->getGrouperVersionAndType();	
    $dg1Data['ID']=$dg1->getID();	
    $dg1Data['Major Diagnostic Category']=$dg1->getMajorDiagnosticCategory();
    $dg1Data['Outlier Cost']=$dg1->getOutlierCost();	
    $dg1Data['Outlier Days']=$dg1->getOutlierDays();	
    $dg1Data['Outlier Type']=$dg1->getOutlierType();




    return view("fileToText",compact("pidData",'in2Data','gt1Data','orcData','obrData','dg1Data'));
}




}



