package main

import (
	"bytes"
	"fmt"
)

const (
	HOST = "127.0.0.1"
	PORT = "8888"
	TYPE = "tcp"
)

func main()  {

	//conn,err := net.Dial(TYPE,HOST+":"+PORT)
	//if err != nil {
	//	fmt.Println(err)
	//	return
	//}
	//
	//fmt.Println("连接成功")
	//defer conn.Close()
	//i:=1
	//for j:=0;j<100;j++ {
	//	str := "NiuShaoGang"
	//	iStr := strconv.Itoa(i)
	//	strAll := str+iStr
	//
	//	strAllLen := len(strAll)
	//	length := int16(strAllLen)
	//	fmt.Printf("strAll %v \n",strAll)
	//	fmt.Printf("strAllLen:%v \n",strAllLen)
	//	fmt.Printf("length:%v \n",length)
	//
	//	pkg := new(bytes.Buffer)
	//	binary.Write(pkg,binary.BigEndian,length)
	//	data := append(pkg.Bytes(),[]byte(strAll)...)
	//	conn.Write([]byte(data))
	//	i++
	//}

	testSlice()

}


func testSlice(){
	str := "niuniuniu"
	strLen := len(str)
	length := int16(strLen)

	fmt.Printf("%T\n",strLen)

	fmt.Printf("%T\n",length)
	pkg := new(bytes.Buffer)
	fmt.Printf("%T\n",pkg)

}