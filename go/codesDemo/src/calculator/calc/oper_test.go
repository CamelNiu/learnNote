package calc

import "testing"

func TestOper(t *testing.T) {
	num1 := 8
	num2 := 8
	flag := "+"
	// ret := OperationFactory(flag).Exe(num1, num2)
	// t.Log(ret)
	ret := OperationFactory(num1, num2, flag).Exe()
	t.Log(ret)
}
