const districtData = {
    "เมืองพิจิตร": ["ในเมือง", "ไผ่ขวาง", "ย่านยาว", "ท่าฬ่อ", "ปากทาง", "คลองคะเชนทร์", "โรงช้าง", "เมืองเก่า", "ท่าหลวง", "บ้านบุ่ง", "ฆะมัง", "ดงป่าคำ", "หัวดง", "ป่ามะคาบ", "สายคำโห้", "ดงกลาง"],
    "วังทรายพูน": ["วังทรายพูน","หนองปลาไหล","หนองพระ","หนองปล้อง"],
    "โพธิ์ประทับช้าง": ["โพธิ์ประทับช้าง","ไผ่ท่าโพ","วังจิก","ไผ่รอบ","ดงเสือเหลือง","เนินสว่าง","ทุ่งใหญ่"],
    "ตะพานหิน": ["ตะพานหิน","งิ้วราย","ห้วยเกตุ","ไทรโรงโขน","หนองพยอม","ทุ่งโพธิ์","ดงตะขบ","คลองคูณ","วังสำโรง","วังหว้า","วังหลุม","ทับหมัน","ไผ่หลวง"],
    "บางมูลนาก": ["บางมูลนาก","บางไผ่","หอไกร","เนินมะกอก","วังสำโรง","ภูมิ","วังกรด","ห้วยเขน","วังตะกู","ลำประดา"],
    "โพทะเล": ["โพทะเล","ท้ายน้ำ","ทะนง","ท่าบัว","ทุ่งน้อย","ท่าขมิ้น","ท่าเสา","บางคลาน","ท่านั่ง","บ้านน้อย","วัดขวาง"],
    "สามง่าม": ["สามง่าม","กำแพงดิน","รังนก","เนินปอ","หนองโสน"],
    "ทับคล้อ": ["ทับคล้อ","เขาทราย","เขาเจ็ดลูก","ท้ายทุ่ง"],
    "สากเหล็ก": ["สากเหล็ก","ท่าเยี่ยม","คลองทราย","หนองหญ้าไทร","วังทับไทร"],
    "บึงนาราง": ["ห้วยแก้ว","โพธิ์ไทรงาม","แหลมรัง","บางลาย","บึงนาราง"],
    "ดงเจริญ": ["วังงิ้วใต้","วังงิ้ว","ห้วยร่วม","ห้วยพุก","สำนักขุนเณร"],
    "วชิรบารมี": ["บ้านนา","บึงบัว","วังโมกข์","หนองหลุม"],
};

document.getElementById('subdistrictSelect').addEventListener('change', function() {
    const selectedDistrict = this.value;
    const districtSelect = document.getElementById('districtSelect');

    districtSelect.innerHTML = '';

    districtData[selectedDistrict].forEach(function(district) {
        const option = document.createElement('option');
        option.textContent = district;
        option.value = district;
        districtSelect.appendChild(option);
    });

    districtSelect.disabled = false;
    districtSelect.required = true;
});