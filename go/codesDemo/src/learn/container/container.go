package container

import (
	"fmt"
)

func ActionMain()  {
	//arr()
	//mutiArr()
	//sliceDemo()
	//operateSliceAppend()
	//opreateSliceCopy()
	//opreateSliceDel()
	//rangeDemo()
	mapDemo()
}

func arr(){
	//数组，固定长度，特定元素，元素数量零个或者多个组成
	//var arrName [elementNum]Type
	//Type为数组本身时，可以实现多维数组
	//下标访问数组，len()返回数组长度

	var a [3]int
	fmt.Println(a[0])
	fmt.Println(a[len(a)-1])

	for i,v := range a {
		fmt.Printf("%d %d\n",i,v)
	}

	for _,v := range a {
		fmt.Printf("%d\n",v)
	}

	for k,_ := range a {
		fmt.Printf("%d\n",k)
	}
	//数组未初始化，会默认当前类型零值
	//数组初始化
	var q [3]int = [3]int{1,2,3}
	var r [3]int = [3]int{1,2}

	fmt.Println(q[2])
	fmt.Println(r[2])

	//...表示数组的长度是根据初始化值的时候元素个数来计算

	p := [...]int{3,4,5,6,7,8}
	fmt.Printf("%T\n",p)

	//大小
	// [3]int{1,2,3}
	//q = [4]int{1,2,3,4}
	
	x := [2]int{1,2}
	y := [...]int{1,2}
	z := [2]int{1,3}
	fmt.Println(x == y,x==z,y==z)

	var arrTeam [3]string

	arrTeam = [3]string{"hammer","soldier","mum"}

	for k,v := range arrTeam {
		fmt.Println(k,v)
	}

}


func mutiArr(){
	//多维数组，场景为具有父子关系或者坐标系相关数据
	//var arrName [size][size]...[size] array_type
	//了解其本质，二维数组也是由众多一维数组构成的
	var arr1 [2][2]int
	arr1 = [2][2]int{{1,2},{3,4}}

	arr1[0][0] = 8

	fmt.Println(arr1[0][0])

}

func sliceDemo(){
	//go语言切片，对数组的一个连续片段的引用，引用类型。内部包含地址，大小和容量，切片一般用于快速地操作一块数据集合
	//切片默认指向一段连续内存区域，可以是数组，也可以是切片本身。
	//slice [start:end]

	//var a = [3]int{1,2,3}
	//fmt.Println(a,a[1:2])

	var highRiseBuilding [30] int
	for i:=0;i<30;i++{
		highRiseBuilding[i] = i+1
	}
	//fmt.Println(highRiseBuilding)
	//fmt.Println(highRiseBuilding[10:15])
	//fmt.Println(highRiseBuilding[10:])
	//fmt.Println(highRiseBuilding[:5])
	//
	//a := []int{1,2,3}
	//fmt.Println(a[:])
	//fmt.Println(a[0:0])
	//
	//var strList []string
	//var numList []int
	//var numListEmpty = []int{}
	//fmt.Println(strList,numList,numListEmpty)
	//fmt.Println(len(strList),len(numList),len(numListEmpty))
	//
	//fmt.Println(strList == nil)
	//fmt.Println(numList == nil)
	//fmt.Println(numListEmpty == nil)//因为numListEmpty已经被分配了内存，但是没有元素，和nil比较是false

	//make([]Type,size,cap)

	//a := make([]int,2)
	//b := make([]int,2,10)
	//fmt.Println(a,b)
	//
	//fmt.Println(len(a),len(b))

	//使用 make() 函数生成的切片一定发生了内存分配操作，但给定开始与结束位置（包括切片复位）的切片只是将新的切片结构指向已经分配好的内存区域，设定开始与结束位置，不会发生内存分配操作。

	var a = [3] int{1,2,3}
	b := a[1:2]

	fmt.Printf("%T",b)

}

func operateSliceAppend(){

	//append()函数，动态为切片添加元素

    //尾部添加元素
	var a []int
	a = append(a,1)
	fmt.Println(a)
	a = append(a,1,2,3,4,5)
	fmt.Println(a)
	a = append(a,[]int{9,8,7,6,5,4,3,2,1}...)
	fmt.Println(a)

	//扩容
	var numbers []int
	for i:=0;i<5;i++{
		numbers = append(numbers,i)
		fmt.Printf("len:%d cap:%d pointer:%p\n",len(numbers),cap(numbers),numbers )
	}
	fmt.Println(numbers)

    //头部添加元素
    //在切片开头添加元素一般都会导致内存的重新分配，而且会导致已有元素全部被复制 1 次，因此，从切片的开头添加元素的性能要比从尾部追加元素的性能差很多。
    var b = []int{1,2,3}
    b = append([]int{9,8,7,6,5},b...)
    b = append([]int{987654321},b...)
    fmt.Println(b)

    //append函数返回的是新切片，所以可以链式操作



}

func opreateSliceCopy(){
//     //copy 函数
//     //copy （a,b []T) int,把b复制到a中，copy() 函数的返回值表示实际发生复制的元素个数
//     slice1 := []int{1,2,3,4,5}
//     slice2 := []int{5,4,3}
//     fmt.Println(slice1)
//     fmt.Println(slice2)
//
//     copy1 := copy(slice2,slice1)
//     fmt.Println(slice1)
//     fmt.Println(slice2)
//
//     copy2 := copy(slice1,slice2)
//     fmt.Println(slice1)
//     fmt.Println(slice2)
//
//     fmt.Println(copy1)
//     fmt.Println(copy2)
//


    const elementCount int = 10000;

    srcData := make([]int,elementCount)

    for i := 0;i<elementCount;i++{
        srcData[i] = i
    }

    //切片不回因为=而进行元素的复制
    refData := srcData

    copyData := make([]int,elementCount)
    copy(copyData,srcData)
    srcData[0] = 999
    fmt.Println(refData[0])
    fmt.Println(copyData[0],copyData[elementCount-1])

    copy(copyData,srcData[4:6])

    for i :=0;i<5;i++ {
        fmt.Printf("%d",copyData[i])
    }

    fmt.Println(refData[0])

}

func opreateSliceDel(){

    //Go语言中删除切片元素的本质是，以被删除元素为分界点，将前后两个部分的内存重新连接起来

//     //1,删除开头的元素，可以直接移动数据指针
//     var b []int
//     b = []int{1,2,3}
//     b = b[1:]
//     b = b[2:]
//     //fmt.Println(b)
//
//     //2,append原地完成
//     var c []int
//     c = []int{1,2,3,4,5,6,7}
//     //fmt.Println(c)
//
//     fmt.Println(c[:0])
//     fmt.Println(c[1:])
//
//     c = append(c[:0],c[1:]...)
//     fmt.Println(c)
//
//
//     //copy完成
//     c = append([]int{1},c...)
//     var d []int
//     //d = copy(c,c[1:])
//     //fmt.Println(d)
//     //c = c[:d]

//[x:] [:x] 开始包含当前值，结束不包含当前值
//     var a []int
//     a = []int{1,2,3,4,5}
//
//     fmt.Println(a[:3])
//     fmt.Println(a[4:])
//
//     tmpA := append(a[:3],a[4:]...)
//
//     fmt.Println( tmpA )

//     a := []int{1,2,3,4,5,6,7,8,9,10}
//
//     a = a[:3+copy( a[3:],a[4:] )]
//
//     fmt.Println(a)
//
//     b := copy( a[3:],a[4:] )
//     fmt.Println(b)
//
//     a := []int{1,2,3}
//     a = a[:len(a)-1]
//     fmt.Println(a)

//     seq := []string{"a","b","c","d","e","f"}
//
//     index := 2
//
//     fmt.Println(seq[:index],seq[index+1:])
//
//     seq = append(seq[:index],seq[index+1:]...)
//
//     fmt.Println(seq)

}

func rangeDemo() {
//     slice := []int{1,2,3,4,5,6}
//
//     for k,v := range slice {
//         fmt.Println(k,v)
//     }

//     slice := []int{10,20,30,40}
//ll
//     for k,v := range slice {
//         fmt.Printf("v:%d,v-addr:%X ele-addr:%X\n",v,&v,&slice[k])
//     }

//     slice := []int{1,2,3,4,5,6,7,8,9}
//     for _,v := range slice{
//         fmt.Println(v)
//     }

    //v := 0
	//
    //for {
    //    fmt.Println(v)
    //    v += 20000000000000000000000000000000000000000000000000000000000000000
    //}

}

func mutiSliceDemo()  {
	//多维切片
	//var slice [][]int
	//slice = [][]int{{10},{100,200}}
	//
	//fmt.Println(slice)

	slice := [][]int{{10},{100,200,300},{400,500,600}}
	slice[0] = append(slice[0],20)
	fmt.Println(slice)


}

func mapDemo()  {
	//map,元素对的无序集合，k-v，关联数组，字典
	//var mapName map[keyType]valueType
	//var mapList map[string]int
	//mapList = map[string]int{"one":1,"two":2}
	//fmt.Println(mapList)
	//
	//mapCreated := make(map[string]float32)
	//mapCreated["key1"] = 3.1415
	//
	//fmt.Println(mapCreated)
	//
	//var mapAssigned map[string]int
	//mapAssigned = mapList
	//fmt.Println(mapAssigned)
	//
	//noteFrequency := map[string]float32 {
	//	"C0": 16.35, "D0": 18.35, "E0": 20.60, "F0": 21.83,
	//	"G0": 24.50, "A0": 27.50, "B0": 30.87, "A4": 440}
	//
	//fmt.Println(noteFrequency)
	//
	////mp1 := make(map[int][]int)
	////mp2 := make(map[int]*[]int)
	//
	//scene := make(map[string]int)
	//
	//scene["route"] = 66
	//scene["brazil"] = 4
	//scene["china"] = 960
	//
	//var sceneList[] string
	//for k := range scene {
	//	sceneList = append(sceneList,k)
	//}
	//
	//fmt.Println(sceneList);
	//sort.Strings(sceneList)
	//fmt.Println(sceneList)
	////for k,v := range scene{
	////	fmt.Println(k,v)
	////}
	//
	//
	////delete(map,key)
	//delete(scene,"route")
	//fmt.Println(scene)

	//ele := []int{2,6,9,5,8}
	//target := 10
	//
	////var res []int
	//res := twoSum(ele,target)
	//
	//fmt.Println(res)

	//var slice []int
	//for i:=0;i<997;i++{
	//	if i%2 == 0 {
	//		slice = append(slice, i)
	//	}
	//}
	//
	//binSearch(slice,68)

	arr1 := []int{1,2,3,4,5}
	fmt.Println(arr1)

}

func binSearch(slice []int,target int)  {

}

func twoSum(nums []int,target int) []int {

	//var keySlice []int
	//
	//for i:=0;i<len(nums);i++ {

	//	for j:=i+1;j<len(nums);j++{
	//		sum := nums[i]+nums[j]
	//		if sum == target {
	//			keySlice = append(keySlice,i,j)
	//		}
	//	}
	//}
	//return keySlice
}

