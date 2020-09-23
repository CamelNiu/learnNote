#include <stdio.h>
#include <limits.h>

int main()
{
    int i;
    i = returnIng();
    return 0;
}


int returnIng()
{
    int abc[3] = {1,2,3};
    for(int j=0;j<3;j++){
        printf("%d",abc[j]);
    }
    return 0;
}