import time

class Leaky(object):
    """docstring for Leaky"""
    water = 0
    pretime = 0

    #container 总容量
    #rate      1s流出量
    #addNum    每次注入量
    def main(self,container,rate,addNum):
        #当前时间
        nowTime = int(time.time())
        #上次到目前流出去的水
        curWater = self.water-( ( nowTime-self.pretime) * rate )
        #水不能为负
        if curWater<0:
            curWater = 0
        #更新本次注入时间
        self.pretime = nowTime
        #水流出了一部分，不是上一次的水了，更新下，注入再更新，不注入则当前水量
        self.water = curWater
        if (curWater+addNum)<=container :
            #通过，注水后更新水量
            self.water = curWater+addNum
            return True
        else:

            return False


#测试
l = Leaky()
for i in range(1,300):
    time.sleep(0.1)
    res = l.main(5,1,2)
    print(res)