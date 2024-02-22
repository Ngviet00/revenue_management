using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace RevenueManagement.Migrations
{
    /// <inheritdoc />
    public partial class rename_table_user_company : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropPrimaryKey(
                name: "PK_UserCompanies",
                table: "UserCompanies");

            migrationBuilder.RenameTable(
                name: "UserCompanies",
                newName: "user_companies");

            migrationBuilder.AddPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies",
                column: "id");
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies");

            migrationBuilder.RenameTable(
                name: "user_companies",
                newName: "UserCompanies");

            migrationBuilder.AddPrimaryKey(
                name: "PK_UserCompanies",
                table: "UserCompanies",
                column: "id");
        }
    }
}
