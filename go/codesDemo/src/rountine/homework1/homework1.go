package homework1

import (
	"fmt"
	"time"
)

func H1Test() {
	ch1 := make(chan string)
	ch2 := make(chan string)
	ch3 := make(chan string)
	go redis(ch1)
	go mysql(ch2)
	go file(ch3)
	//fmt.Println(<-ch3)
	//fmt.Println(<-ch2)
	//fmt.Println(<-ch1)
	select {
		case a:=<-ch3:
			fmt.Println(a)
			return
		case a:=<-ch2:
			fmt.Println(a)
			return
		case a:=<-ch1:
			fmt.Println(a)
			return
	}

	time.Sleep(time.Second*8)

}

func redis(ch chan<- string){
	time.Sleep(time.Second*1)
	ch<-"redis"
}

func mysql(ch chan<- string){
	time.Sleep(time.Second*2)
	ch<-"mysql"
}

func file(ch chan<- string){
	time.Sleep(time.Second*3)
	ch<-"file"
}