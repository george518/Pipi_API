<?php
//算法复习专题

// 冒泡排序法 两两比较，较小的向上
$arr = array(12,3,1,34,55,32,56,35,77);

function bubbleSort($arr)
{
	$length = count($arr);
	if ($length<=1) {
		return $arr;
	}

	//转为索引数组
	$arr = array_values($arr);
	//控制比较次数
	for ($i=1; $i<$length ; $i++) { 
		for ($j=0; $j < $length-$i; $j++) { 
			if ($arr[$j]>$arr[$j+1]) {
				$tmp       = $arr[$j];
				$arr[$j]   = $arr[$j+1];
				$arr[$j+1] = $tmp;
			}
		}
	}

	return $arr;
}

// $newArr = bubbleSort($arr);
// print_r($newArr);

//选择排序 先假设第一个元素是最小的，然后逐个和其他元素比较，如果其他元素小于假设元素则交换位置
function selectSort($arr)
{
	$length = count($arr);
	if ($length<=1) {
		return $arr;
	}

	//转为索引数组
	$arr = array_values($arr);

	for ($i=0; $i < $length-1 ; $i++) { 
		$p = $i;
		for ($j=$i+1; $j < $length; $j++) { 
			if ($arr[$p]>$arr[$j]) {
				$tmp     = $arr[$p];
				$arr[$p] = $arr[$j];
				$arr[$j] = $tmp;
			}
		}
	}
	return $arr;
}

$selectSort = selectSort($arr);
print_r($selectSort);

?>