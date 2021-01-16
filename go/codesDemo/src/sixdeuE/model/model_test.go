package model

import (
	"fmt"
	"testing"
)

func TestRfData(t *testing.T) {
	userDatas = make(map[string]Model,0)
	rfdata("user","username",userDatas)
	//for _, v := range userDatas {
	//	fmt.Println(v.ToString())
	//}

	for k,v := range userDatas {
		fmt.Println(k,v)
	}


}