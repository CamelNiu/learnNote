package calc

type OperationInterface interface {
	Exe(a, b int) int
}

type OperationAdd struct{}
type OperationSub struct{}
type OperationMul struct{}
type OperationDiv struct{}

func (this *OperationAdd) Exe(a int, b int) int {
	return a + b
}

func (this *OperationSub) Exe(a int, b int) int {
	return a - b
}

func (this *OperationMul) Exe(a int, b int) int {
	return a * b
}

func (this *OperationDiv) Exe(a int, b int) int {
	return a / b
}
