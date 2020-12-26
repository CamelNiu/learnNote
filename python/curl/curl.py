import createData,requests

r = requests.get( 'http://dev.jkb.com:28080/siteapi/tasks/index/getheadlinetaskinfos?limit=12&random=1608280862974' )
print(r.status_code)