
res = [];

for a in range(1,10):
    for b in range(1,10):
        for c in range(1,10):
            for d in range(1,10):
                ab = a*10+b
                cd = c*10+d
                ba = b*10+a
                dc = d*10+c
                if (ab*cd == ba*dc) and (ab != cd) and (a != b) and (ab != dc) :

                        res.append(str(ab)+"--"+str(dc));

