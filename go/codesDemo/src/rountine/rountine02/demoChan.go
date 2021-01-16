package rountine02
//
//import (
//	"fmt"
//	"math/rand"
//	"sync"
//	"time"
//)
//
//func DemoChan () {
//	demo2()
//}
//
///**
//1,channel写入数据
// */
//func demo1(){
//
//}
//
//func demo3() {
//	for  {
//		n := rand.Intn(100)
//		fmt.Println(n)
//		if n == 28 {
//			break
//		}
//	}
//}
//
//func init(){
//	rand.Seed(time.Now().UnixNano())
//}
//
//var wg sync.WaitGroup
//
//func demo2(){
//	court := make(chan int)
//	wg.Add(2)
//	go player("Lin",court)
//	go player("Lee",court)
//
//	court <- 1
//	wg.Wait()
//
//}
//
//func player(name string,court chan int){
//	defer wg.Done()
//
//	for{
//		ball,ok := <- court
//
//		if !ok{
//			fmt.Println("play %s won\n",name)
//			return
//		}
//
//		n := rand.Intn(100)
//		if n%13 == 0 {
//			fmt.Println("paly %s fail\n",name)
//			close(court)
//			return
//		}
//
//		fmt.Printf("play %s Hit %d\n",name,ball)
//		ball++
//		court <- ball
//
//	}
//
//}