package main

import (
	"fmt"
	"log"
	"net/http"
)

func main(){
	http.HandleFunc("/", index)
	log.Fatal(http.ListenAndServe("localhost:8111",nil))
}


func index(w http.ResponseWriter,r *http.Request){
	fmt.Fprintf(w,"热爱代码 hello world")
}