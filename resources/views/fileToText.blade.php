<table border="1" width="100%">
<tr>
<td style="background-color:black; color:white;">
                    PID SIGMENT ("The PID segment is used by all applications as the primary means of communicating patient identification information. This segment contains permanent patient identifying and demographic information that, for the most part, is not likely to change frequently.")
          </td>
</tr>

<?php 

foreach($pidData as $key=>$value)
{
        
          echo "<tr><td>".$key."</td>";
          
          echo "<td>";
          if(is_array($value))
          {
                    foreach($value as $getValue)
                    {
                              echo $getValue." ";
                    }
          }
          else{
                    echo $value;

          }
        echo"</td></tr>"; 
}


?>


<tr>
          <td style="background-color:black; color:white;">
                    IN1 SIGMENT ("The IN1 segment contains insurance policy coverage information necessary to produce properly pro-rated and patient and insurance bills.")
          </td>
</tr>
<?php 
foreach($in2Data as $key1=>$value1)
{        
          echo "<tr><td>".$key1."</td>";
          
          echo "<td>";
          if(is_array($value1))
          {
                    foreach($value1 as $getValue1)
                    {
                              echo $getValue1." ";
                    }
          }
          else{
                    echo $value1;
          }
        echo"</td></tr>"; 
}
?>


<tr>
          <td style="background-color:black; color:white;">
          GT1 Segment ("The GT1 segment contains guarantor (e.g., the person or the organization with financial responsibility for payment of a patient account) data for patient and insurance billing applications.")
          </td>
</tr>
<?php 
foreach($gt1Data as $key2=>$value2)
{        
          echo "<tr><td>".$key2."</td>";
          
          echo "<td>";
          if(is_array($value2))
          {
                    foreach($value2 as $getValue2)
                    {
                              echo $getValue2." ";
                    }
          }
          else{
                    echo $value2;
          }
        echo"</td></tr>"; 
}
?>

<tr>
          <td style="background-color:black; color:white;">
                    ORC SIGMENT ("The Common Order segment (ORC) is used to transmit fields that are common to all orders (all types of services that are requested).")
          </td>
</tr>
<?php 
foreach($orcData as $key3=>$value3)
{        
          echo "<tr><td>".$key3."</td>";
          
          echo "<td>";
          if(is_array($value3))
          {
                    foreach($value3 as $getValue3)
                    {
                              echo $getValue3." ";
                    }
          }
          else{
                    echo $value3;
          }
        echo"</td></tr>"; 
}
?>

<tr>
          <td style="background-color:black; color:white;">
                    OBR SIGMENT ("The Observation Request (OBR) segment is used to transmit information specific to an order for a diagnostic study or observation, physical exam, or assessment.")
          </td>
</tr>
<?php 
foreach($obrData as $key4=>$value4)
{        
          echo "<tr><td>".$key4."</td>";
          
          echo "<td>";
          if(is_array($value4))
          {
                    foreach($value4 as $getValue4)
                    {
                              echo $getValue4." ";
                    }
          }
          else{
                    echo $value4;
          }
        echo"</td></tr>"; 
}
?>
<tr>
          <td style="background-color:black; color:white;">
                    DG1 SIGMENT ("The DG1 segment contains patient diagnosis information of various types, for example, admitting, primary, etc. The DG1 segment is used to send multiple diagnoses (for example, for medical records encoding). It is also used when the FT1-19 - diagnosis code - FT1 does not provide sufficient information for a billing system. This diagnosis coding should be distinguished from the clinical problem segment used by caregivers to manage the patient (see Chapter 12, Patient Care). Coding methodologies are also defined.")
          </td>
</tr>
<?php 
foreach($dg1Data as $key5=>$value5)
{        
          echo "<tr><td>".$key5."</td>";
          
          echo "<td>";
          if(is_array($value5))
          {
                    foreach($value5 as $getValue5)
                    {
                              echo $getValue5." ";
                    }
          }
          else{
                    echo $value5;
          }
        echo"</td></tr>"; 
}
?>
</table>