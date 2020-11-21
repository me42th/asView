## [ASN]()
```
{
    "id": 1, 
    "org_id": 8897, 
    "name": "GTT Communications (AS4436)", 
    "asn": 4436, 
    "policy_general": "Restrictive", 
    "created": "2004-07-28T00:00:00Z", 
    "updated": "2018-08-29T14:21:57Z"
}
```

# [NETIXLAN]()

```
    [id] => 44361
    [net_id] => 2402
    [ix_id] => 18
    [name] => LINX LON1: Main
    [ixlan_id] => 18
    [asn] => 35574
    [created] => 2018-10-09T09:16:28Z
    [updated] => 2018-10-09T09:16:28Z
    
``` 

# [IX]()
```
    [id] => 18
    [org_id] => 791
    [name] => LINX LON1
    [city] => London
    [country] => GB
    [region_continent] => Europe
    [created] => 2010-07-29T00:00:00Z
    [updated] => 2020-06-29T07:53:16Z
``` 

---------------------------------------------------------------------
RELATORIOS
---------------------------------------------------------------------

``` 
select tabela.out_name as 'intersecao' from
(
    select ix.out_name 
    from asn 
    	join net_ix_lan as pivot 
    		on pivot.out_asn = asn.out_asn 
    	join ix 
    		on pivot.out_ix_id = ix.out_id      
    where asn.out_asn = 28186
) as tabela 
	join (
    	select ix.out_name 
		from asn      
			join net_ix_lan as pivot          
				on pivot.out_asn = asn.out_asn      
			join ix
				on pivot.out_ix_id = ix.out_id      
    	where asn.out_asn = 12322
) as tabela2 
on tabela.out_name = tabela2.out_name;

select ix.out_name as 'uniao'
	from asn      
		join net_ix_lan as pivot          
			on pivot.out_asn = asn.out_asn      
		join ix
			on pivot.out_ix_id = ix.out_id      
where asn.out_asn = 12322
union
select ix.out_name 
	from asn      
		join net_ix_lan as pivot          
			on pivot.out_asn = asn.out_asn      
		join ix
			on pivot.out_ix_id = ix.out_id      
where asn.out_asn = 28186;

select ix.out_name as 'diferenca'
from asn 
	join net_ix_lan as pivot 
		on pivot.out_asn = asn.out_asn 
	join ix 
		on pivot.out_ix_id = ix.out_id      
where asn.out_asn = 12322
and ix.out_name not in(
	select ix.out_name 
		from asn      
			join net_ix_lan as pivot          
				on pivot.out_asn = asn.out_asn      
			join ix
				on pivot.out_ix_id = ix.out_id      
	where asn.out_asn = 28186
) group by ix.out_name;
``` 