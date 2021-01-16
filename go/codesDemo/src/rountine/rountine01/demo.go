package rountine01

import (
	"fmt"
	"sync"
	"time"
)

var wg sync.WaitGroup

func DemoPkg(){

	fmt.Println(time.Now())

	//wg.Add(1)
	 redis()
	//wg.Add(1)
	 mysql()
	//wg.Add(1)
	 file()
	//wg.Wait()

	fmt.Println(time.Now())
}


func redis() {
	//defer wg.Done()
	fmt.Println("start redis")
	time.Sleep(time.Second)
	fmt.Println("end redis")
}

func mysql() {
	//defer wg.Done()
	fmt.Println("start mysql")
	time.Sleep(time.Second*2)
	fmt.Println("end mysql")
}

func file() {
	//defer wg.Done()
	fmt.Println("start file")
	time.Sleep(time.Second*3)
	fmt.Println("end file")
}

