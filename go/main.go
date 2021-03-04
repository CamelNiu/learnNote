package main

import "fmt"

func main()  {

	ins := struct {
		a int
		b string
	}{
		a:1,
		b:"abc",
	}

	ins2 := &struct {
		a int
		b string
	}{
		a:1,
		b:"abc",
	}

	fmt.Printf("%T\n",ins)
	fmt.Printf("%T\n",ins2)

	fmt.Println(ins)
	fmt.Println(ins2)

}