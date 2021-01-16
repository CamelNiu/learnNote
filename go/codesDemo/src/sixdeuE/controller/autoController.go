package controller

import (
	"fmt"
	"sixedu/model"
	"sixedu/util"
)

type AutoController struct {

}

func (c *AutoController) login() bool {
	fmt.Println("输入用户名")
	username := util.CRead()
	fmt.Println("输入密码")
	password := util.CRead()

	user := model.GetUser(username)
	if user == nil {
		fmt.Println("查询不到用户", username)
		return false
	}
	if user.GetPassword() == password {
		fmt.Println("登入成功")
		return true
	} else {
		fmt.Println("密码错误")

		return false
	}
}
