using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace RevenueManagement.Migrations
{
    /// <inheritdoc />
    public partial class table_user : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "users",
                columns: table => new
                {
                    id = table.Column<long>(type: "bigint", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    username = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    password = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    phone = table.Column<string>(type: "nvarchar(15)", maxLength: 15, nullable: true),
                    email = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    image = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    sex = table.Column<int>(type: "int", nullable: true, comment: "1: male, 2: female"),
                    date_of_birth = table.Column<DateOnly>(type: "date", nullable: true),
                    role_id = table.Column<int>(type: "int", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: true),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_users", x => x.id);
                });

            migrationBuilder.InsertData(
                table: "users",
                columns: new[] { "id", "created_at", "date_of_birth", "deleted_at", "email", "image", "name", "password", "phone", "role_id", "sex", "updated_at", "username" },
                values: new object[] { 1L, null, null, null, "", "", "superadmin", "123456", "", 1, 1, null, "superadmin" });
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "users");
        }
    }
}
