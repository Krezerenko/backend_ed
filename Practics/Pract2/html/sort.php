<?php

function mergeSort(array $arr)
{
    $length = count($arr);
    if ($length <= 1) return $arr;

    $mid = (int)($length / 2);
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    $left = mergeSort($left);
    $right = mergeSort($right);

    return merge($left, $right);
}

function merge(array $left, array $right)
{
    $result = [];
    $i = 0;
    $j = 0;

    while ($i < count($left) && $j < count($right))
    {
        if ($left[$i] <= $right[$j])
        {
            $result[] = $left[$i];
            $i++;
        }
        else
        {
            $result[] = $right[$j];
            $j++;
        }
    }

    while ($i < count($left))
    {
        $result[] = $left[$i];
        $i++;
    }

    while ($j < count($right))
    {
        $result[] = $right[$j];
        $j++;
    }

    return $result;
}

echo "<p>Initial values: ".$_GET["nums"]."</p>";
$nums = explode(",", $_GET["nums"]);

$nums = mergeSort($nums);
echo "<p>Sorted values: ";
foreach ($nums as $num)
{
    echo "$num ";
}
echo "</p>";