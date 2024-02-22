using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace RevenueManagement.Migrations
{
    /// <inheritdoc />
    public partial class AddUserCompanyRelationship : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies");

            migrationBuilder.AlterColumn<long>(
                name: "user_id",
                table: "user_companies",
                type: "bigint",
                nullable: false,
                oldClrType: typeof(int),
                oldType: "int");

            migrationBuilder.AlterColumn<long>(
                name: "company_id",
                table: "user_companies",
                type: "bigint",
                nullable: false,
                oldClrType: typeof(int),
                oldType: "int");

            migrationBuilder.AddPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies",
                columns: new[] { "user_id", "company_id" });

            migrationBuilder.CreateIndex(
                name: "IX_user_companies_company_id",
                table: "user_companies",
                column: "company_id");

            migrationBuilder.AddForeignKey(
                name: "FK_user_companies_companies_company_id",
                table: "user_companies",
                column: "company_id",
                principalTable: "companies",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);

            migrationBuilder.AddForeignKey(
                name: "FK_user_companies_users_user_id",
                table: "user_companies",
                column: "user_id",
                principalTable: "users",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_user_companies_companies_company_id",
                table: "user_companies");

            migrationBuilder.DropForeignKey(
                name: "FK_user_companies_users_user_id",
                table: "user_companies");

            migrationBuilder.DropPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies");

            migrationBuilder.DropIndex(
                name: "IX_user_companies_company_id",
                table: "user_companies");

            migrationBuilder.AlterColumn<int>(
                name: "company_id",
                table: "user_companies",
                type: "int",
                nullable: false,
                oldClrType: typeof(long),
                oldType: "bigint");

            migrationBuilder.AlterColumn<int>(
                name: "user_id",
                table: "user_companies",
                type: "int",
                nullable: false,
                oldClrType: typeof(long),
                oldType: "bigint");

            migrationBuilder.AddPrimaryKey(
                name: "PK_user_companies",
                table: "user_companies",
                column: "id");
        }
    }
}
