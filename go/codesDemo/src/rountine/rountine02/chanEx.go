package rountine02

import (
	"fmt"
	"sync"
	"time"
)

var wg sync.WaitGroup

func JieLi()  {
	ch := make(chan int)
	quit := make(chan bool)

	go func (){
		for{
			select {
			case num := <-ch:
				fmt.Println("num = ", num)


			case <-time.After(time.Second * 3):
				fmt.Println("超时")
				quit <- true
			}
		}
	}()

	for i:=0;i<5;i++{
		ch <- i
		time.Sleep(time.Second)
	}

	<-quit

	fmt.Println("程序结束")


}












// Runner 模拟接力比赛中的一位跑步者
func Runner(baton chan int) {
	var newRunner int
	// 等待接力棒
	runner := <-baton
	// 开始绕着跑道跑步
	fmt.Printf("Runner %d Running With Baton\n", runner)
	// 创建下一位跑步者
	if runner != 4 {
		newRunner = runner + 1
		fmt.Printf("Runner %d To The Line\n", newRunner)
		go Runner(baton)
	}
	// 围绕跑道跑
	time.Sleep(200 * time.Millisecond)
	// 比赛结束了吗？
	if runner == 4 {
		fmt.Printf("Runner %d Finished, Race Over\n", runner)
		wg.Done()
		return
	}
	// 将接力棒交给下一位跑步者
	fmt.Printf("Runner %d Exchange With Runner %d\n",
		runner,
		newRunner)
	baton <- newRunner
}


func BufferChan(){
	ch := make(chan int,3)
	fmt.Println(len(ch))
	// 发送3个整型元素到通道
	ch <- 1
	ch <- 2
	ch <- 3
	ch <- 4
	// 查看当前通道的大小


	fmt.Println(len(ch))
}

func multi(){

	ch := make(chan int , 1)
	for{
		select{
			case ch <- 0 :
				case ch <- 1:
		}

		i := <-ch
		fmt.Println("Value received:",i)

	}

}

