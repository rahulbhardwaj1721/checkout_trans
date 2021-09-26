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

