# import mysql.connector
# import json
# import sys
# from datetime import datetime, timedelta
# from collections import defaultdict

# # Konfigurasi database Laravel
# db_config = {
#     "host": "127.0.0.1",
#     "user": "root",
#     "password": "",
#     "database": "rojember"
# }

# # ✅ Bobot WMA: bulan terlama = bobot 1, bulan terbaru = bobot 3
# weights = [1, 2, 3]
# sum_weight = sum(weights)  # Total = 6

# try:
#     conn = mysql.connector.connect(**db_config)
#     cursor = conn.cursor(dictionary=True)

#     # 📅 Ambil data pemakaian bahan baku per bulan (3 bulan terakhir)
#     # PENTING: Gunakan format() untuk avoid masalah % escaping
#     query = """
#     SELECT 
#         m.id AS material_id,
#         m.name AS material_name,
#         m.stock AS current_stock,
#         m.unit AS unit,
#         DATE_FORMAT(p.production_date, '{date_format}') AS period,
#         SUM(pm.quantity_used) AS total_used
#     FROM production_materials pm
#     JOIN productions p ON pm.production_id = p.id
#     JOIN materials m ON pm.material_id = m.id
#     WHERE p.production_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
#       AND p.status = 'selesai'
#     GROUP BY m.id, m.name, m.stock, m.unit, period
#     ORDER BY m.id, period ASC
#     """.format(date_format='%Y-%m')
    
#     cursor.execute(query)
#     rows = cursor.fetchall()

#     # 🔍 Debug: Print raw rows
#     print(f"DEBUG: Total rows fetched = {len(rows)}", file=sys.stderr)
#     for row in rows:
#         print(f"DEBUG ROW: {row}", file=sys.stderr)

#     if len(rows) == 0:
#         print(json.dumps([]))
#         sys.exit(0)

#     # 📦 Kelompokkan data per bahan baku
#     materials = defaultdict(lambda: {
#         "name": "",
#         "unit": "",
#         "stock": 0,
#         "usage": []
#     })

#     for row in rows:
#         mid = row["material_id"]
#         materials[mid]["name"] = row["material_name"]
#         materials[mid]["unit"] = row["unit"]
#         materials[mid]["stock"] = float(row["current_stock"])
#         materials[mid]["usage"].append({
#             "period": row["period"],
#             "total_used": float(row["total_used"])
#         })

#     # 🔍 Debug: Print grouped materials
#     print(f"DEBUG: Total materials grouped = {len(materials)}", file=sys.stderr)

#     # 🧮 Hitung WMA untuk tiap bahan baku
#     forecast_results = []
#     next_period = (datetime.now().replace(day=1) + timedelta(days=32)).strftime("%Y-%m")

#     for mid, mat in materials.items():
#         usage_data = mat["usage"]
        
#         # 🔍 Debug: Print usage data per material
#         print(f"DEBUG: Material ID {mid} ({mat['name']}) has {len(usage_data)} months of data", file=sys.stderr)
#         print(f"DEBUG: Usage data: {usage_data}", file=sys.stderr)
        
#         # ✅ Minimal 3 bulan data diperlukan
#         if len(usage_data) < 3:
#             print(f"DEBUG: Skipping material {mat['name']} - only {len(usage_data)} months", file=sys.stderr)
#             continue
        
#         # ✅ Ambil 3 bulan terakhir (sudah diurutkan ASC dari query)
#         last_3_months = usage_data[-3:]
        
#         # 🔍 Debug: Print calculation
#         print(f"DEBUG: Calculating WMA for {mat['name']}", file=sys.stderr)
#         print(f"DEBUG: Last 3 months: {last_3_months}", file=sys.stderr)
        
#         # ✅ Hitung WMA: (data_lama * 1 + data_tengah * 2 + data_baru * 3) / 6
#         wma = 0
#         for i, data in enumerate(last_3_months):
#             contribution = data["total_used"] * weights[i]
#             wma += contribution
#             print(f"DEBUG: Month {i+1}: {data['total_used']} x {weights[i]} = {contribution}", file=sys.stderr)
        
#         forecast_value = round(wma / sum_weight, 2)
#         print(f"DEBUG: WMA Result: {wma} / {sum_weight} = {forecast_value}", file=sys.stderr)
        
#         # 📊 Hitung kebutuhan pengadaan
#         current_stock = mat["stock"]
#         needed = max(0, forecast_value - current_stock)
        
#         forecast_results.append({
#             "material_id": mid,
#             "material_name": mat["name"],
#             "unit": mat["unit"],
#             "forecast_value": forecast_value,
#             "current_stock": current_stock,
#             "needed": round(needed, 2),
#             "period": next_period
#         })

#     # 🔍 Debug: Print final results count
#     print(f"DEBUG: Total forecast results = {len(forecast_results)}", file=sys.stderr)

#     if len(forecast_results) == 0:
#         error_response = {
#             "error": "Tidak ada material dengan data minimal 3 bulan",
#             "debug_info": {
#                 "total_materials": len(materials),
#                 "materials_with_data": {k: len(v["usage"]) for k, v in materials.items()},
#                 "suggestion": "Pastikan setiap material memiliki data pemakaian minimal 3 bulan berturut-turut"
#             }
#         }
#         print(json.dumps(error_response))
#         sys.exit(1)

#     # 🔽 Urutkan berdasarkan kebutuhan terbesar
#     forecast_results = sorted(forecast_results, key=lambda x: x["needed"], reverse=True)

#     # 📤 Output JSON untuk Laravel
#     print(json.dumps(forecast_results, indent=2))

# except mysql.connector.Error as err:
#     error_response = {
#         "error": f"Database error: {str(err)}",
#         "details": str(err)
#     }
#     print(json.dumps(error_response), file=sys.stderr)
#     sys.exit(1)
# except Exception as e:
#     error_response = {
#         "error": f"Python error: {str(e)}",
#         "type": type(e).__name__,
#         "details": str(e)
#     }
#     print(json.dumps(error_response), file=sys.stderr)
#     sys.exit(1)
# finally:
#     if 'cursor' in locals():
#         cursor.close()
#     if 'conn' in locals():
#         conn.close()

import mysql.connector
import json
import sys
from datetime import datetime, timedelta
from collections import defaultdict

# Konfigurasi database Laravel
db_config = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "rojember"
}

# ✅ Bobot WMA: bulan terlama = bobot 1, bulan terbaru = bobot 3
weights = [1, 2, 3]
sum_weight = sum(weights)  # Total = 6

try:
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)

    # 📅 Ambil data pemakaian bahan baku per bulan (3 bulan terakhir)
    query = """
    SELECT 
        m.id AS material_id,
        m.name AS material_name,
        m.stock AS current_stock,
        m.unit AS unit,
        DATE_FORMAT(p.production_date, '{date_format}') AS period,
        SUM(pm.quantity_used) AS total_used
    FROM production_materials pm
    JOIN productions p ON pm.production_id = p.id
    JOIN materials m ON pm.material_id = m.id
    WHERE p.production_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
      AND p.status = 'selesai'
    GROUP BY m.id, m.name, m.stock, m.unit, period
    ORDER BY m.id, period ASC
    """.format(date_format='%Y-%m')
    
    cursor.execute(query)
    rows = cursor.fetchall()

    if len(rows) == 0:
        print(json.dumps([]))
        sys.exit(0)

    # 📦 Kelompokkan data per bahan baku
    materials = defaultdict(lambda: {
        "name": "",
        "unit": "",
        "stock": 0,
        "usage": []
    })

    for row in rows:
        mid = row["material_id"]
        materials[mid]["name"] = row["material_name"]
        materials[mid]["unit"] = row["unit"]
        materials[mid]["stock"] = float(row["current_stock"])
        materials[mid]["usage"].append({
            "period": row["period"],
            "total_used": float(row["total_used"])
        })

    # 🧮 Hitung WMA untuk tiap bahan baku
    forecast_results = []
    next_period = (datetime.now().replace(day=1) + timedelta(days=32)).strftime("%Y-%m")

    for mid, mat in materials.items():
        usage_data = mat["usage"]
        
        # ✅ Minimal 3 bulan data diperlukan
        if len(usage_data) < 3:
            continue
        
        # ✅ Ambil 3 bulan terakhir (sudah diurutkan ASC dari query)
        last_3_months = usage_data[-3:]
        
        # ✅ Hitung WMA: (data_lama * 1 + data_tengah * 2 + data_baru * 3) / 6
        wma = 0
        for i, data in enumerate(last_3_months):
            wma += data["total_used"] * weights[i]
        
        forecast_value = round(wma / sum_weight, 2)
        
        # 📊 Hitung kebutuhan pengadaan
        current_stock = mat["stock"]
        needed = max(0, forecast_value - current_stock)
        
        forecast_results.append({
            "material_id": mid,
            "material_name": mat["name"],
            "unit": mat["unit"],
            "forecast_value": forecast_value,
            "current_stock": current_stock,
            "needed": round(needed, 2),
            "period": next_period
        })

    # 🔽 Urutkan berdasarkan kebutuhan terbesar
    forecast_results = sorted(forecast_results, key=lambda x: x["needed"], reverse=True)

    # 📤 Output JSON untuk Laravel
    print(json.dumps(forecast_results, indent=2))

except mysql.connector.Error as err:
    error_response = {"error": f"Database error: {str(err)}"}
    print(json.dumps(error_response))
    sys.exit(1)
except Exception as e:
    error_response = {"error": f"Python error: {str(e)}"}
    print(json.dumps(error_response))
    sys.exit(1)
finally:
    if 'cursor' in locals():
        cursor.close()
    if 'conn' in locals():
        conn.close()