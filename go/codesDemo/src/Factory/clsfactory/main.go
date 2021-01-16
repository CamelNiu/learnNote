package main

import (
	"Factory/clsfactory/base"
	_ "Factory/clsfactory/cls2"
	_ "Factory/clsfactory/cls1"
)

func main(){

	c1 := base.Create("Class1")
	c1.Do()

}

