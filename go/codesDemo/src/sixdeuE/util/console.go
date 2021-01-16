package util

import (
	"bufio"
	"os"
	"strings"
)

var inputReader *bufio.Reader

func init() {
	inputReader = bufio.NewReader(os.Stdin)
}

func CRead() string {
	input, _ := inputReader.ReadString('\n')
	return strings.TrimSpace(strings.TrimSuffix(input, "\n"))
}
