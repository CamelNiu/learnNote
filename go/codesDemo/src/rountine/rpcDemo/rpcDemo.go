package rpcDemo

import (
	"errors"
	"fmt"
	"time"
)

func RpcMain()  {
	ch := make(chan string)

	go RPCServer(ch)

	recv,err := RPCClient(ch,"hi")

	if err!=nil {
		fmt.Println(err)
	} else {
		fmt.Println("服务端收到数据",recv)
	}

}


func RPCClient(ch chan string,req string)(string,error){
	ch <- req

	select{
	case ack := <-ch:
		return ack,nil
	case <- time.After(time.Second):
		return "",errors.New("程序超时")

	}

}

func RPCServer(ch chan string){
	for {
		data := <-ch
		fmt.Println("服务器接收到数据：",data)
		time.Sleep(time.Second*3)
		ch <- "roger"
	}
}
