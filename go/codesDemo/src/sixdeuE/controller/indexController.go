package controller

import "fmt"

type IndexController struct {
}

func (c *IndexController) Welcome() {
	fmt.Println("欢迎来到，六星教育系统")
	fmt.Println("你要执行的操作")
}
