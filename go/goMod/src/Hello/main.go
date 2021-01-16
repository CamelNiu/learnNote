package main

import (
	"fmt"
	api "Hello/api"
	email "github.com/shineyork/go-email"
)

func main (){
	fmt.Println("This is test Go Mod")
	api.TestDemo()
	email.Email()
}
