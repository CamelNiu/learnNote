package model

import "strconv"

type User struct {
	username string
	password string
	age int
	sex string
}

var userDatas map[string]Model

func NewUser() *User{
	return &User{}
}

func (u *User) SetUsername(username string){
	u.username = username
}

func (u *User) SetPassword(password string){
	u.password = password
}

func (u *User) SetAge(age int){
	u.age = age
}

func (u *User) SetSex(sex string){
	u.sex = sex
}

func (u *User) GetUsername() string{
	return u.username
}

func (u *User) GetPassword() int{
	return u.age
}

func (u *User) GetSex() string{
	return u.sex
}


func (u *User) ToString() string {
	return u.username + "," + u.password + "," + strconv.Itoa(u.age) + "," + u.sex
}










