package pkgHttp

import (
	"fmt"
	"io/ioutil"
	"net/http"
	"runtime"
	"strings"
	"sync"
	"time"
)

var wg sync.WaitGroup

func TestDemo()  {


	runtime.GOMAXPROCS(8)


	time1 := time.Now().UnixNano()

	var cycle,i int64
	cycle = 100

	for i=0;i<cycle;i++ {
		wg.Add(1)
		go curl()
	}

	wg.Wait()

	time2 := time.Now().UnixNano()

	timeSub := time2-time1

	perTime := timeSub/cycle

	var unit int64
	unit = 1e9

	var result float64
	result = float64( perTime) / float64( unit)

	fmt.Println(timeSub)
	fmt.Println(result)


}

func curl()  {
	defer wg.Done()
	url := "http://dev.jkb.com:28080/userapi/monitor/agent/list?page=1&page_size=20&status=&monitor_flag=&last_paused_user=1"
	token := "9fac3700b9a143679cd8e9a57da11f52"
	httpReq := NewHttpReq(url,token)
	httpReq.getHttp()
}

type ReqFunc interface {

}

type HttpReq struct {
	url string
	token string
}

func NewHttpReq(url,token string) *HttpReq {
	return &HttpReq{
		url:url,
		token:token,
	}
}

func (this *HttpReq) getHttp()  {
	client := &http.Client{}
	req, _ := http.NewRequest("GET", this.url, nil)
	req.Header.Add("token", this.token)
	resp,err := client.Do(req)
	fmt.Println(err)
	body,_:= ioutil.ReadAll(resp.Body)
	fmt.Println( string( body))
}





func putHttp(){
	url := "http://dev.jkb.com:28080/userapi/monitor/agent/modifystatus/1042"

	client := &http.Client{}

	req,err := http.NewRequest("PUT",url,strings.NewReader("type=pause"))

	if err != nil {
		fmt.Println(err)
	}

	req.Header.Set("token","06616640c78837431e74c09d0bcfc79d")
	req.Header.Set("Content-Type","application/x-www-form-urlencoded")

	resp,err := client.Do(req)

	if err != nil{
		fmt.Println(err)
	}

	fmt.Println(err)
	fmt.Println(resp)

}



