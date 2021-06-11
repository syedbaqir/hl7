<table border="1">
<tr>
          <td>
                    PID SIGMENT
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
</table>