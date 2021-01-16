package service

import (
	"userList/model"
)

type CustomerService struct {
	customers []model.Customer
	customerNum int
}

func NewCustomerService() *CustomerService{
	CustomerService := &CustomerService{}
	CustomerService.customerNum = 1
	customer := model.NewCustomer(1,"牛少刚","male",20,"18588532127","camel@163.com")
	CustomerService.customers = append(CustomerService.customers,customer)
	return CustomerService
}

func (this *CustomerService) List() []model.Customer {
	return this.customers
}

func(this *CustomerService) Add(customer model.Customer) bool {
	this.customerNum++
	customer.Id = this.customerNum
	this.customers = append(this.customers,customer)
	return true;
}

func(this *CustomerService) Delete(id int) bool{
	index := this.FindById(id)
	if index == -1 {
		return false
	}
	this.customers = append(this.customers[:index],this.customers[index+1:]...)
	return true
}

func(this *CustomerService) FindById(id int) int {
	index := -1

	for i:=0;i<len(this.customers);i++{
		if this.customers[i].Id == id {
			index = i
		}
	}

	return index

}
