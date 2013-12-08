<?php

    /*
    * Copyright © 2005-2009 Cosmopoly Europe EOOD (http://netenberg.com).
    * All Rights Reserved.
    *
    * This Cosmopoly Europe EOOD work (including software, documents, or
    * other related items) is being provided by the copyright holder under
    * the following license. By obtaining, using and/or copying this work,
    * you (the licensee) agree that you have read, understood, and will
    * comply with the following terms and conditions:
    *
    * Permission to use, copy, modify, and distribute this software and its
    * documentation, with or without modification, for any purpose and
    * without fee or royalty is hereby granted, provided that you include
    * the following on ALL copies of the software and documentation or
    * portions thereof, including modifications, that you make:
    *
    * 1. The full text of this NOTICE in a location viewable to users of the
    * redistributed or derivative work.
    *
    * 2. A short notice of the following form (hypertext is preferred, text
    * is permitted) should be used within the body of any redistributed or
    * derivative code: "Copyright © 2005-2009 Cosmopoly Europe EOOD
    * (http://netenberg.com). All Rights Reserved."
    *
    * 3. Notice of any changes or modifications to the W3C files, including
    * the date changes were made. (We recommend you provide URIs to the
    * location from which the code is derived.)
    *
    * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
    * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
    * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR FITNESS
    * FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE OR
    * DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS, COPYRIGHTS,
    * TRADEMARKS OR OTHER RIGHTS.
    * COPYRIGHT HOLDERS WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL
    * OR CONSEQUENTIAL DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR
    * DOCUMENTATION.
    *
    * The name and trademarks of copyright holders may NOT be used in
    * advertising or publicity pertaining to the software without specific,
    * written prior permission. Title to copyright in this software and any
    * associated documentation will at all times remain with copyright
    * holders.
    */

    $tld_array['com']= array ("server" => "whois.crsnic.net", "nomatch" => "No match for");
    $tld_array['net']= array ("server" => "whois.crsnic.net", "nomatch" => "No match for");
    $tld_array['org']= array ("server" => "whois.publicinterestregistry.net", "nomatch" => "NOT FOUND");
    $tld_array['biz']= array ("server" => "whois.nic.biz", "nomatch" => "Not found");
    $tld_array['info']= array ("server" => "whois.afilias.net", "nomatch" => "NOT FOUND");
    $tld_array['ca']= array ("server" => "whois.cira.ca", "nomatch" => "AVAIL");
    $tld_array['de']= array ("server" => "whois.denic.de", "nomatch" => "free");
    $tld_array['dk']= array ("server" => "whois.dk-hostmaster.dk", "nomatch" => "No entries found");
    $tld_array['fo']= array ("server" => "whois.ripe.net", "nomatch" => "No entries found");
    $tld_array['no']= array ("server" => "whois.norid.no", "nomatch" => "no matches");
    $tld_array['nu']= array ("server" => "whois.nic.nu", "nomatch" => "NO MATCH for");
    $tld_array['pl']= array ("server" => "whois.dns.pl", "nomatch" => "does not exists");
    $tld_array['com.pl']= array ("server" => "whois.dns.pl", "nomatch" => "does not exists");
    $tld_array['net.pl']= array ("server" => "whois.dns.pl", "nomatch" => "does not exists");
    $tld_array['org.pl']= array ("server" => "whois.dns.pl", "nomatch" => "does not exists");
    $tld_array['fr']= array ("server" => "whois.nic.fr", "nomatch" => "No entries found");
    $tld_array['tm.fr']= array ("server" => "whois.nic.fr", "nomatch" => "No entries found");
    $tld_array['com.fr']= array ("server" => "whois.nic.fr", "nomatch" => "No entries found");
    $tld_array['asso.fr']= array ("server" => "whois.nic.fr", "nomatch" => "No entries found");
    $tld_array['presse.fr']= array ("server" => "whois.nic.fr", "nomatch" => "No entries found");
    $tld_array['my']= array ("server" => "whois.mynic.net.my", "nomatch" => "does not Exist in database");
    $tld_array['com.my']= array ("server" => "whois.mynic.net.my", "nomatch" => "does not Exist in database");
    $tld_array['net.my']= array ("server" => "whois.mynic.net.my", "nomatch" => "does not Exist in database");
    $tld_array['org.my']= array ("server" => "whois.mynic.net.my", "nomatch" => "does not Exist in database");
    $tld_array['name.my']= array ("server" => "whois.mynic.net.my", "nomatch" => "does not Exist in database");
    $tld_array['is']= array ("server" => "whois.isnic.is", "nomatch" => "No entries found");
    $tld_array['it']= array ("server" => "whois.nic.it", "nomatch" => "No entries found");
    $tld_array['ru']= array ("server" => "whois.ripn.net", "nomatch" => "No entries found");
    $tld_array['com.ru']= array ("server" => "whois.ripn.net", "nomatch" => "No entries found");
    $tld_array['net.ru']= array ("server" => "whois.ripn.net", "nomatch" => "No entries found");
    $tld_array['org.ru']= array ("server" => "whois.ripn.net", "nomatch" => "No entries found");
    $tld_array['se']= array ("server" => "whois.nic-se.se", "nomatch" => "No data found");
    $tld_array['ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['com.ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['net.ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['org.ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['info.ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['gov.ro']= array ("server" => "whois.rotld.ro", "nomatch" => "No entries found");
    $tld_array['com.sg']= array ("server" => "whois.nic.net.sg", "nomatch" => "NOMATCH");
    $tld_array['org.sg']= array ("server" => "whois.nic.net.sg", "nomatch" => "NOMATCH");
    $tld_array['net.sg']= array ("server" => "whois.nic.net.sg", "nomatch" => "NOMATCH");
    $tld_array['gov.sg']= array ("server" => "whois.nic.net.sg", "nomatch" => "NOMATCH");
    $tld_array['at']= array ("server" => "whois.aco.net", "nomatch" => "nothing found");
    $tld_array['co.at']= array ("server" => "whois.aco.net", "nomatch" => "nothing found");
    $tld_array['or.at']= array ("server" => "whois.aco.net", "nomatch" => "nothing found");
    $tld_array['sk']= array ("server" => "whois.sk-nic.sk", "nomatch" => "Not found");
    $tld_array['tm']= array ("server" => "whois.nic.tm", "nomatch" => "No match");
    $tld_array['com.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['net.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['org.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['edu.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['gen.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['web.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['info.tr']= array ("server" => "whois.metu.edu.tr", "nomatch" => "No match found for");
    $tld_array['mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['com.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['org.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['net.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['edu.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['gov.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['gob.mx']= array ("server" => "whois.nic.mx", "nomatch" => "Referencias de Organization No Encontradas");
    $tld_array['nl']= array ("server" => "whois.domain-registry.nl", "nomatch" => "is free");
    $tld_array['ac.jp']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match");
    $tld_array['co.jp']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match");
    $tld_array['go.jp']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match");
    $tld_array['or.jp']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match");
    $tld_array['ne.jp']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match");
    $tld_array['ie']= array ("server" => "whois.domainregistry.ie", "nomatch" => "There was no match in the IE Domain");
    $tld_array['us']= array ("server" => "whois.nic.us", "nomatch" => "Not found:");
    $tld_array['aero']= array ("server" => "whois.information.aero", "nomatch" => "is available");
    $tld_array['gr']= array ("server" => "https://grweb.ics.forth.gr/Whois?lang=en&domainName=%domain%", "nomatch" => "The domain can be provisioned");
    $tld_array['lt']= array ("server" => "http://whois.domreg.lt/index.php?dm_domain=%domain%", "nomatch" => "No domain records found");
    $tld_array['eu']= array ("server" => "http://www1.whois.eu/whois/GetDomainStatus.htm?domainName=%domainName%", "nomatch" => "AVAILABLE");
    $tld_array['jptop']= array ("server" => "whois.nic.ad.jp", "nomatch" => "No match!!");
    $tld_array['tw']= array ("server" => "whois.twnic.net.tw", "nomatch" => "No Match");
    $tld_array['com.tw']= array ("server" => "whois.twnic.net", "nomatch" => "No Records Found");
    $tld_array['org.tw']= array ("server" => "whois.twnic.net", "nomatch" => "No Records Found");
    $tld_array['net.tw']= array ("server" => "whois.twnic.net", "nomatch" => "No Records Found");
    $tld_array['co.za']= array ("server" => "http://co.za/cgi-bin/whois.sh?Domain=[domain]", "nomatch" => "No Matches");
    $tld_array['net.za']= array ("server" => "whois.co.za", "nomatch" => "No Matches");
    $tld_array['org.za']= array ("server" => "whois.co.za", "nomatch" => "No Matches");
    $tld_array['web.za']= array ("server" => "whois.co.za", "nomatch" => "No Matches");
    $tld_array['ch']= array ("server" => "whois.nic.ch", "nomatch" => "not have an entry");
    $tld_array['ws']= array ("server" => "whois.nic.ws", "nomatch" => "No match for");
    $tld_array['tv']= array ("server" => "http://www.tv/en-def-9769f7c1581a/cgi-bin/multilookup.cgi?domain=%domainName%&tld=%domainExt%", "nomatch" => "is available");
    $tld_array['name']= array ("server" => "whois.nic.name", "nomatch" => "No match");
    $tld_array['ac.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['co.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['go.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['ne.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['nm.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['or.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['re.kr']= array ("server" => "whois.nic.or.kr", "nomatch" => "is not registered");
    $tld_array['in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['co.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['net.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['org.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['gen.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['firm.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['ind.in']= array ("server" => "whois.inregistry.in", "nomatch" => "NOT FOUND");
    $tld_array['ab.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['bc.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['mb.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['nb.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['nf.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['ns.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['nt.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['on.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['pe.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['qc.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['sk.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['yk.ca']= array ("server" => "whois.cira.ca", "nomatch" => "Not found");
    $tld_array['be']= array ("server" => "whois.dns.be", "nomatch" => "Status: FREE");
    $tld_array['ac.be']= array ("server" => "whois.dns.be", "nomatch" => "Status: FREE");
    $tld_array['cc']= array ("server" => "whois.nic.cc", "nomatch" => "No match");
    $tld_array['asn.au']= array ("server" => "whois-check.ausregistry.net.au", "nomatch" => "[!]Not Available");
    $tld_array['com.au']= array ("server" => "whois-check.ausregistry.net.au", "nomatch" => "[!]Not Available");
    $tld_array['edu.au']= array ("server" => "whois-check.ausregistry.net.au", "nomatch" => "[!]Not Available");
    $tld_array['org.au']= array ("server" => "whois-check.ausregistry.net.au", "nomatch" => "[!]Not Available");
    $tld_array['net.au']= array ("server" => "whois-check.ausregistry.net.au", "nomatch" => "[!]Not Available");
    $tld_array['lv']= array ("server" => "whois.nic.lv", "nomatch" => "Nothing found");
    $tld_array['hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['co.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['2000.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['erotika.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['jogasz.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['sex.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['video.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['info.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['agrar.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['film.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['konyvelo.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['shop.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['org.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['bolt.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['forum.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['lakas.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['suli.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['priv.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['casino.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['games.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['media.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['szex.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['sport.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['city.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['hotel.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['news.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['tozsde.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['tm.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['erotica.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['ingatlan.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['reklam.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['utazas.hu']= array ("server" => "whois.nic.hu", "nomatch" => "Nincs tal�lat / No match");
    $tld_array['cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['ac.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['com.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['edu.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['gov.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['net.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['org.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['bj.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['sh.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['tj.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['cq.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['he.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['nm.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['ln.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['jl.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['hl.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['js.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['zj.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['ah.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['hb.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['hn.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['gd.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['gx.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['hi.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['sc.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['gz.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['yn.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['xz.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['sn.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['gs.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['qh.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['nx.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['xj.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['tw.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['hk.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['mo.cn']= array ("server" => "whois.cnnic.net.cn", "nomatch" => "No match");
    $tld_array['br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['adm.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['adv.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['am.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['arq.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['art.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['bio.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['cng.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['cnt.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['com.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['ecn.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['eng.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['esp.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['etc.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['tur.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['eti.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['fm.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['fot.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['fst.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['g12.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['gov.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['ind.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['inf.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['jor.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['lel.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['med.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['mil.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['net.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['nom.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['ntr.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['odo.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['org.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['ppg.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['pro.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['psc.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['psi.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['rec.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['slg.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['tmp.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['tv.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['vet.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['zlg.br']= array ("server" => "whois.nic.br", "nomatch" => "No match for");
    $tld_array['br.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['cn.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['eu.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['hu.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['no.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['qc.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['sa.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['se.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['se.net']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['us.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['uy.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['za.com']= array ("server" => "whois.centralnic.com", "nomatch" => "No match");
    $tld_array['pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['com.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['net.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['org.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['edu.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['nome.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['publ.pt']= array ("server" => "whois.dns.pt", "nomatch" => "no match");
    $tld_array['fi']= array ("server" => "whois.ficora.fi", "nomatch" => "Domain not");
    $tld_array['co.uk']= array ("server" => "whois.nic.uk", "nomatch" => "No match");
    $tld_array['org.uk']= array ("server" => "whois.nic.uk", "nomatch" => "No match");
    $tld_array['ltd.uk']= array ("server" => "whois.nic.uk", "nomatch" => "No match");
    $tld_array['plc.uk']= array ("server" => "whois.nic.uk", "nomatch" => "No match");
    $tld_array['me.uk']= array ("server" => "whois.nic.uk", "nomatch" => "No match");
?>
