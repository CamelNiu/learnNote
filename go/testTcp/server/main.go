package main

import (
	"bufio"
	"bytes"
	"encoding/binary"
	"errors"
	"fmt"
	"net"
)

const (
	HOST = "127.0.0.1"
	PORT = "8888"
	TYPE = "tcp"
)


func main() {

	listen,err := net.Listen(TYPE,HOST+":"+PORT)
	if err != nil {
		fmt.Println(err)
		return
	}

	fmt.Println("Server Start...")

	for {
		conn,err := listen.Accept()
		if err != nil {
			fmt.Println(err)
			return
		}
		handle(conn)
	}

}

func handle(c net.Conn)  {
	fmt.Println("Server:connect Success")
	//var data [1024]byte
	defer c.Close()
	reader := bufio.NewReader(c)
	for  {
		//n, err := bufio.NewReader(c).Read(data[:])
		//if err != nil {
		//	fmt.Println("err: ", err)
		//	return
		//}
		//res := string(data[:n])
		//fmt.Printf("%v\n",res)
		msg,err := unpack(reader)
		if err != nil {
			fmt.Println(err)
			break;
		}
		fmt.Println(msg)
	}
}

func unpack(reader *bufio.Reader) (string,error)  {
	lenByte,_ := reader.Peek(2)
	lengthBuff := bytes.NewBuffer(lenByte)
	var length int16
	err := binary.Read(lengthBuff,binary.BigEndian,&length)
	fmt.Println("length : ",length)
	if err != nil {
		return "",err
	}

	if int16(reader.Buffered()) < length+2 {
		return "",errors.New("data error")
	}

	pack := make([]byte,int(2+length))
	_,err = reader.Read(pack)
	if err != nil {
		return "", err
	}
	return string(pack[2:]),nil

}