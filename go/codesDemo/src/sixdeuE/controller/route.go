package controller

import (
	"fmt"
	"strconv"
	"sixdeuE/util"
)

var (
	autoController *AutoController
	next           string
	sessionid      bool
)

func Run(){
	dispatch()
}

func dispatch() {
	fmt.Println("==========>>>start============>>>")
	fmt.Println("欢迎来到六星教育系统")
	fmt.Println("请选择你要执行的操作")
	oper := []string{"登陆", "注册"}
	for k, v := range oper {
		fmt.Printf("(%d) : %s \n", k, v)
	}
	flag, _ := strconv.Atoi(util.CRead())
	fmt.Println(flag)

	fmt.Println("======= >>> end ======>>> ")

	fmt.Println("======= >>> start ======>>> ")

	// if 是否为登入 =>
	switch flag {
	case 0:
		al := autoController.login()
		if al {
			sessionid = true
		}
	case 1:
	}
	fmt.Println("======= >>> end ======>>> ")
	fmt.Println("======= >>> start ======>>> ")
	if sessionid { // 登入成功
		oper = []string{"用户信息展示", "修改用户", "添加用户"}
		for k, v := range oper {
			fmt.Printf("(%d) : %s\n", k, v)
		}
		flag, _ = strconv.Atoi(util.CRead())
		switch flag {
		case 0:
			// 用户信息展示

			// ??
			oper = []string{"返回", "修改用户", "添加用户"}
			fmt.Println("======= >>> end ======>>> ")
		case 1:
			// 修改用户
			// case 2:
			// 	// 添加用户
			fmt.Println("======= >>> end ======>>> ")
		}
		fmt.Println("======= >>> end ======>>> ")

	}
}