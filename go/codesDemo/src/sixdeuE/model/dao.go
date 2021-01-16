package model

import (
	"bufio"
	"errors"
	"fmt"
	"io"
	"os"
	"reflect"
	"strconv"
	"strings"
)

//定义一个接口,User实现了方法，说明User结构体继承自该接口
type Model interface {
	ToString() string//格式化输出数据信息
}

//定义常量
var (
	path string = "/Users/niushaogang/learn/learnNote/go/codesDemo/src/sixdeuE/data/"
	suffix string = ".sql"
	//定义models变量，是为字典，字符串为键，接口任意类型为值
	models map[string]interface{}
)

func init() {
	//初始化models变量
	models = make(map[string]interface{})
	//初始化变量之后，给models变量赋值，user=>构造方法
	models["user"] = NewUser
}

func rfdata(name, pirmay string, datas map[string]Model) error {
	//打开文件
	f,ferr := os.Open(path+name+suffix)
	if ferr != nil {
		fmt.Println("文件读取异常",ferr)
		return errors.New("文件查询不到 error")
	}
	//执行完之后关闭文件
	defer f.Close()
	//创建一个具有默认大小的缓冲
	buf := bufio.NewReader(f)
	//实例化一个切片
	field := make([]string,0)
	for{
		//按照行数读取文件
		row,rerr := buf.ReadBytes('\n')
		if rerr != nil {
			if rerr == io.EOF {
				break
			}
			fmt.Println("抛出缓存读取文件异常",rerr)
		}
		data1 := strings.TrimSuffix(string(row), "\n")
		//字符串切片
		data := strings.Split(data1,",")
		if len(field) == 0{
			field = data //存储字段
			for k,v := range data {
				field[k] = v
			}
		}else{
			toModel(name,pirmay,datas,data,field)
		}
	}
	return nil
}

func toModel(name,pirmay string,datas map[string]Model,data,field []string) error {
	// 2.2.1. 根据name得到模型
	if models[name] == nil {
		return errors.New("不存在模型 : " + name)
	}
	// 2.2.2. 利用反射-》对模型赋值 -- 如果是采用构造函数的方式则需要利用反射获取
	modelV := reflect.ValueOf(models[name]).Call([]reflect.Value{})[0]
	var primayValue string
	for k,v := range data {
		if field[k] == pirmay {
			primayValue = v
		}
		fset := modelV.MethodByName("Set" + strings.Title(field[k]))
		fset.Call([]reflect.Value{
			reflect.ValueOf(toTypeValue(modelV,field[k],v)),
		})
	}
	datas[primayValue] = modelV.Interface().(Model)
	return nil
}


func toTypeValue(modelV reflect.Value, field, value string) interface{} {
	mtype := modelV.Elem().FieldByName(field).Type().Name()
	switch mtype {
	case "int":
		b, _ := strconv.Atoi(value)
		return b
	}
	return string(value)
}
