package reflactDemo

type Enum int

const Zero Enum = 0



func execReflactDemo () {
//将类型本身作为第一类的值类型处理
//程序在编译时变量被转换为内存地址，变量名不会被编译器写入到可执行部分，在运行程序时程序无法获取自身的信息。
//支持反射的语言可以在程序编译期将变量的反射信息，如字段名称、类型信息、结构体信息等整合到可执行文件中，并给程序提供接口访问反射信息，这样就可以在程序运行期获取类型的反射信息，并且有能力修改它们
//指针变量的类型为空
	//var a int
	//typeOfA := reflect.TypeOf(a)
	//fmt.Println(typeOfA)
	//fmt.Println(typeOfA.Name(),typeOfA.Kind())

	//type cat struct {
	//
	//}
	//
	////获取类型对象
	//typeOfCat := reflect.TypeOf(cat{})
	////类型对象的名称和种类
	//fmt.Println(typeOfCat.Name(),typeOfCat.Kind())
	//
	//typeOfZero := reflect.TypeOf(Zero)
	//
	//fmt.Println(typeOfZero.Name(),typeOfZero.Kind())

	//type cat struct {
	//	def int
	//}
	//
	//ins := &cat{}
	//
	//
	//fmt.Println(ins)
	//
	//typeOfCat := reflect.TypeOf(ins)
	//
	//fmt.Printf("name:'%v' kind:'%v'\n",typeOfCat.Name(),typeOfCat.Kind())

	//var num float64 = 1.2345
	//
	//pointer := reflect.ValueOf(&num)
	//value := reflect.ValueOf(num)
	//
	//convertPointer := pointer.Interface().(*float64)
	//convertValue := value.Interface().(float64)
	//
	//fmt.Println(convertPointer)
	//fmt.Println(convertValue)

	//fmt.Println("reflectDemo")

}


