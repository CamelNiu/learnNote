package main

import (
	"fmt"
	"net"
	"strconv"
	"time"
)

const (
	HOST = "127.0.0.1"
	PORT = "8888"
	TYPE = "tcp"
)

func main() {
	addRess := HOST+":"+PORT
	conn,err := net.Dial(TYPE,addRess)
	if err != nil {
		fmt.Println(err)
		return
	}
	fmt.Println("连接成功")
	defer conn.Close()
	i := 0
	for{

		time.Sleep(1*time.Second)
		a := strconv.Itoa(i)
		conn.Write([]byte(a))
		//var data [1024]byte
		//n,_ := conn.Read(data[:])
		//fmt.Println( string(data[:n]) )
		i++
	}



}
