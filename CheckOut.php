<?php

class CheckOut
{
    public function __construct($priceRules)
    {
        $this->priceRules = json_decode($priceRules);
    }

    private function setQuantity($pid)
    {
        $this->pid[$pid] =  !isset($this->pid[$pid]) ? 1 : $this->pid[$pid] + 1;
        return  $this->pid[$pid];
    }

    public function scanItem($pId)
    {
        try {
            $this->setQuantity($pId);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function costItems()
    {
        try {
            $result = 0;
            foreach ((array) $this->pid as $item => $quantity) {

                $itemFound = array_search($item, array_column($this->priceRules, 'pid'));

                if ($itemFound !== false &&  $this->priceRules[$itemFound]->quantity) {
                    list($quotient, $remainder) = $this->getQuotientAndRemainder($quantity, $this->priceRules[$itemFound]->quantity);
                    $result += ($quotient * $this->priceRules[$itemFound]->spprice) + ($remainder * $this->priceRules[$itemFound]->actualcost);
                } else {
                    $result += $quantity * $this->priceRules[$itemFound]->actualcost;
                }
            }
            return  '$' . $result;
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }


    private function getQuotientAndRemainder($divisor, $dividend)
    {
        $quotient = (int)($divisor / $dividend);
        $remainder = $divisor % $dividend;
        return array($quotient, $remainder);
    }
}

$co = new CheckOut(file_get_contents('items.json'));
$co->scanItem('b');
$co->scanItem('a');
$co->scanItem('b');
$co->scanItem('b');
$co->scanItem('b');
$co->scanItem('b');
$co->scanItem('c');
$co->scanItem('d');
echo $co->costItems();




<?php

function countArray($array1,$array2){
     $result= (count($array1)>count($array2)) ? $array1 : $array2;
     return $result;
}
$a=array(1,6,8,6);
$b=array(1,1,5);
$resultant=countArray($a,$b);
$finalResult = array();
$qoutient = 0;
foreach($resultant as $key =>$value){
    $valueSum=(@$a[count($a)-$key-1])+(@$b[count($b)-$key-1])+ $qoutient;
    $qoutient = intval($valueSum/10);
    $reminder = $valueSum%10;
    $finalResult[] = $reminder;
   
}
print_r(array_reverse($finalResult)) ;
?>





<?php


function happyNo($input,$array){
    $squareSum=0;
    $input= "$input";
    for($i = 0; $i < strlen($input);$i++){
        $squareSum = $squareSum+pow($input[$i], 2);
    }

    if($squareSum ==1)
        return true;

    if(in_array($squareSum,$array))
        return false;
    $array[] =  $squareSum;  
    return happyNo($squareSum,$array);
}
    

$result = happyNo(13,[]);
echo $result;

?>


loop of each digit and square sum
<?php
function square($n){
    $squareSum= 0;
    while($n){
    $reminder = $n%10;
    $squareSum +=$reminder*$reminder;
    $n= intval($n/10);
    
    }
    return $squareSum;
}

echo square(15);
?>



