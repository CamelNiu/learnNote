package main

import (
	"bufio"
	"fmt"
	"net"
)

const (
	HOST = "127.0.0.1"
	PORT = "8888"
	TYPE = "tcp"
)

func main() {

	tcpAdd := HOST+":"+PORT
	//监听端口，创建tcp连接
	listen,err := net.Listen(TYPE,tcpAdd)
	if err != nil {
		fmt.Println(err)
		return
	}

	fmt.Println("Start Server "+tcpAdd+":")

	for {
		//接受客户端连接
		conn,err := listen.Accept()
		if err != nil {
			fmt.Println(err)
			return
		}
		go handle(conn)
	}

}


func handle(c net.Conn) {
	fmt.Println("Client Connect Success")

	for{
		var data [2048]byte
		n, err := bufio.NewReader(c).Read(data[:])
		if err != nil {
			fmt.Println("err : ", err)
			return
		}
		res := string(data[:n])
		fmt.Println(res)
		//c.Write([]byte("Hello world client"))
	}
}

